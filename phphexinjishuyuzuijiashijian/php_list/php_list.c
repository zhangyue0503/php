/*
  +----------------------------------------------------------------------+
  | PHP Version 5                                                        |
  +----------------------------------------------------------------------+
  | Copyright (c) 1997-2016 The PHP Group                                |
  +----------------------------------------------------------------------+
  | This source file is subject to version 3.01 of the PHP license,      |
  | that is bundled with this package in the file LICENSE, and is        |
  | available through the world-wide-web at the following url:           |
  | http://www.php.net/license/3_01.txt                                  |
  | If you did not receive a copy of the PHP license and are unable to   |
  | obtain it through the world-wide-web, please send a note to          |
  | license@php.net so we can mail you a copy immediately.               |
  +----------------------------------------------------------------------+
  | Author:                                                              |
  +----------------------------------------------------------------------+
*/

/* $Id$ */

#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include "php.h"
#include "php_ini.h"
#include "ext/standard/info.h"
#include "php_php_list.h"
#include "list.h"

/* If you declare any globals in php_php_list.h uncomment this:
ZEND_DECLARE_MODULE_GLOBALS(php_list)
*/

/* True global resources - no need for thread safety here */
static int le_php_list;
static int freed = 0;

void list_destroy_handler(zend_rsrc_list_entry *rsrc TSRMLS_DC)
{
    if(!freed){
        list_head *list;

        list = (listhead*)rsrc->ptr;
        list_destory(list);
       
        freed = 1;
    }
}
const zend_function_entry php_list_function[] = {
    PHP_FE(list_create,		NULL)
    PHP_FE(list_add_head,	NULL)
    PHP_FE(list_fetch_head,	NULL)
    PHP_FE(list_add_tail,	NULL)
    PHP_FE(list_fetch_tail,	NULL)
    PHP_FE(list_fetch_index,	NULL)
    PHP_FE(list_delete_index,	NULL)
    PHP_FE(list_destroy,	NULL)
    PHP_FE(list_element_nums,	NULL)
    [NULL,NULL,NULL]
};

/* {{{ PHP_INI
 */
/* Remove comments and fill if you need to have entries in php.ini
PHP_INI_BEGIN()
    STD_PHP_INI_ENTRY("php_list.global_value",      "42", PHP_INI_ALL, OnUpdateLong, global_value, zend_php_list_globals, php_list_globals)
    STD_PHP_INI_ENTRY("php_list.global_string", "foobar", PHP_INI_ALL, OnUpdateString, global_string, zend_php_list_globals, php_list_globals)
PHP_INI_END()
*/
/* }}} */

/* Remove the following function when you have successfully modified config.m4
   so that your module can be compiled into PHP, it exists only for testing
   purposes. */

/* Every user-visible function in PHP should document itself in the source */
/* {{{ proto string confirm_php_list_compiled(string arg)
   Return a string to confirm that the module is compiled in */
PHP_FUNCTION(list_create)
{
	list_head *list;
	list = list_create();
	if(!list){
		RETURN_NULL();
	}else{
		ZEND_REGISTER_RESOURCE(return_value,le_php_list);
	}

//	char *arg = NULL;
//	int arg_len, len;
//	char *strg;
//
//	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s", &arg, &arg_len) == FAILURE) {
//		return;
//	}

//	len = spprintf(&strg, 0, "Congratulations! You have successfully modified ext/%.78s/config.m4. Module %.78s is now compiled into PHP.", "php_list", arg);
//	RETURN_STRINGL(strg, len, 0);
}
/* }}} */
PHP_FUNCTION(list_add_head)
{
	zval *value;
	zval *lrc;
	list_head *list;
	if(zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC,"rz",&lrc,&value)==FAILURE){
		RETURN_FALSE;
	}
	
	ZEND_FETCH_RESOURCE(list,list_head*,&lrc,-1,"List Resource",le_php_list);

	list_add_head(list,value);

	RETURN_TRUE;
}
PHP_FUNCTION(list_fetch_head)
{
	zval *lrc,*retval;
	list_head *list;
	int res;
	
	if(zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC,"r",&lrc)==FAILURE){
		RETURN_FALSE;
	}

	ZEND_FETCH_RESOURCE(list,list_head*,&lrc,-1,"List Resource",le_php_list);

	res = list_fetch(list,0,&retval);

	if(!res){
		RETURN_NULL();
	}else{
		RETURN_ZVAL(retval,1,0);
	}
}
PHP_FUNCTION(list_add_tail)
{
	zval *value;
	zval *lrc;
	list_head *list;
	
	if(zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC,"rz",&lrc,&value)==FAILURE){
		RETURN_FALSE;
	}

	ZEND_FETCH_RESOURCE(list,list_head*,&lrc,-1,"List Resource",le_php_list);
	list_add_tail(list,value);
	RETURN_TRUE;
}
PHP_FUNCTION(list_fetch_tail)
{
	zval *lrc,*retval;
	list_head *list;
	int res;
	
	if(zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC,"r",&lrc)==FAILURE){
		RETURN_FALSE;
	}

	ZEND_FETCH_RESOURCE(list,list_head*,&lrc,-1,"List Resource",le_php_list);
	
	res = list_fetch(list,list_length(list)-1,&retval);
	
	if(!res){
		RETURN_NULL();
	}else{
		RETURN_ZVAL(retval,1,0);
	}
}
PHP_FUNTION(list_fetch_index)
{
	zval *lrc,*retval;
	list_head *list;
	long index;
	int res;


	if(zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC,"rl",&lrc,&index)==FAILURE){
		RETURN_FALSE;
	}

	ZEND_FETCH_RESOURCE(list,list_head*,&lrc,-1,"List Resource",le_php_list);

	res = list_fetch(list,index,&retval);

	if(!res){
		RETURN_NULL();
	}else{
		RETURN_ZVAL(retval,1,0);
	}

}

PHP_FUNCTION(list_element_nums)
{
	zval *lrc;
	list_head *list;
	
	if(zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC,"r",&lrc)==FAILURE){
		RETURN_FALSE;
	}

	ZEND_FETCH_RESOURCE(list,list_head*,&lrc,-1,"List Resource",le_php_list);
	
	RETURN_LONG(list_length(list));
}
PHP_FUNCTION(list_delete_index)
{
	zval *lrc;
	list_head *list;
	long index;
	

	if(zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC,"rl",&lrc,&index)==FAILURE){
		RETURN_FALSE;
	}

	ZEND_FETCH_RESOURCE(list,list_head*,&lrc,-1,"List Resource",le_php_list);

	if(list_delete(list,index)){
		RETURN_TRUE;
	}else{
		RETURN_FALSE;
	}
}
PHP_FUNCTION(list_destroy)
{
	zval *lrc;
	list_head *list;
	
	
	if(zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC,"r",&lrc)==FAILURE){
		RETURN_FALSE;
	}

	ZEND_FETCH_RESOURCE(list,list_head*,&lrc,-1,"List Resource",le_php_list);
	if(!freed){
		list_destroy(list);
		freed = 1;
	}
}
/* The previous line is meant for vim and emacs, so it can correctly fold and 
   unfold functions in source code. See the corresponding marks just before 
   function definition, where the functions purpose is also documented. Please 
   follow this convention for the convenience of others editing your code.
*/


/* {{{ php_php_list_init_globals
 */
/* Uncomment this function if you have INI entries
static void php_php_list_init_globals(zend_php_list_globals *php_list_globals)
{
	php_list_globals->global_value = 0;
	php_list_globals->global_string = NULL;
}
*/
/* }}} */

/* {{{ PHP_MINIT_FUNCTION
 */
PHP_MINIT_FUNCTION(php_list)
{
	/* If you have INI entries, uncomment these lines 
	REGISTER_INI_ENTRIES();
	*/
	return SUCCESS;
}
/* }}} */

/* {{{ PHP_MSHUTDOWN_FUNCTION
 */
PHP_MSHUTDOWN_FUNCTION(php_list)
{
	/* uncomment this line if you have INI entries
	UNREGISTER_INI_ENTRIES();
	*/
	return SUCCESS;
}
/* }}} */

/* Remove if there's nothing to do at request start */
/* {{{ PHP_RINIT_FUNCTION
 */
PHP_RINIT_FUNCTION(php_list)
{
	return SUCCESS;
}
/* }}} */

/* Remove if there's nothing to do at request end */
/* {{{ PHP_RSHUTDOWN_FUNCTION
 */
PHP_RSHUTDOWN_FUNCTION(php_list)
{
	return SUCCESS;
}
/* }}} */

/* {{{ PHP_MINFO_FUNCTION
 */
PHP_MINFO_FUNCTION(php_list)
{
	php_info_print_table_start();
	php_info_print_table_header(2, "php_list support", "enabled");
	php_info_print_table_end();

	/* Remove comments if you have entries in php.ini
	DISPLAY_INI_ENTRIES();
	*/
}
/* }}} */

/* {{{ php_list_functions[]
 *
 * Every user visible function must have an entry in php_list_functions[].
 *
*const zend_function_entry php_list_functions[] = {
*	PHP_FE(confirm_php_list_compiled,	NULL)		For testing, remove later.
*	PHP_FE_END	 Must be the last line in php_list_functions[] 
*};
* }}} */

/* {{{ php_list_module_entry
 */
zend_module_entry php_list_module_entry = {
	STANDARD_MODULE_HEADER,
	"php_list",
	php_list_functions,
	PHP_MINIT(php_list),
	PHP_MSHUTDOWN(php_list),
	PHP_RINIT(php_list),		/* Replace with NULL if there's nothing to do at request start */
	PHP_RSHUTDOWN(php_list),	/* Replace with NULL if there's nothing to do at request end */
	PHP_MINFO(php_list),
	PHP_PHP_LIST_VERSION,
	STANDARD_MODULE_PROPERTIES
};
/* }}} */

#ifdef COMPILE_DL_PHP_LIST
ZEND_GET_MODULE(php_list)
#endif

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: noet sw=4 ts=4 fdm=marker
 * vim<600: noet sw=4 ts=4
 */
