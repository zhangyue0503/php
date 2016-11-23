dnl $Id$
dnl config.m4 for extension php_list

dnl Comments in this file start with the string 'dnl'.
dnl Remove where necessary. This file will not work
dnl without editing.

dnl If your extension references something external, use with:

dnl PHP_ARG_WITH(php_list, for php_list support,
dnl Make sure that the comment is aligned:
dnl [  --with-php_list             Include php_list support])

dnl Otherwise use enable:

dnl PHP_ARG_ENABLE(php_list, whether to enable php_list support,
dnl Make sure that the comment is aligned:
dnl [  --enable-php_list           Enable php_list support])

if test "$PHP_PHP_LIST" != "no"; then
  dnl Write more examples of tests here...

  dnl # --with-php_list -> check with-path
  dnl SEARCH_PATH="/usr/local /usr"     # you might want to change this
  dnl SEARCH_FOR="/include/php_list.h"  # you most likely want to change this
  dnl if test -r $PHP_PHP_LIST/$SEARCH_FOR; then # path given as parameter
  dnl   PHP_LIST_DIR=$PHP_PHP_LIST
  dnl else # search default path list
  dnl   AC_MSG_CHECKING([for php_list files in default path])
  dnl   for i in $SEARCH_PATH ; do
  dnl     if test -r $i/$SEARCH_FOR; then
  dnl       PHP_LIST_DIR=$i
  dnl       AC_MSG_RESULT(found in $i)
  dnl     fi
  dnl   done
  dnl fi
  dnl
  dnl if test -z "$PHP_LIST_DIR"; then
  dnl   AC_MSG_RESULT([not found])
  dnl   AC_MSG_ERROR([Please reinstall the php_list distribution])
  dnl fi

  dnl # --with-php_list -> add include path
  dnl PHP_ADD_INCLUDE($PHP_LIST_DIR/include)

  dnl # --with-php_list -> check for lib and symbol presence
  dnl LIBNAME=php_list # you may want to change this
  dnl LIBSYMBOL=php_list # you most likely want to change this 

  dnl PHP_CHECK_LIBRARY($LIBNAME,$LIBSYMBOL,
  dnl [
  dnl   PHP_ADD_LIBRARY_WITH_PATH($LIBNAME, $PHP_LIST_DIR/$PHP_LIBDIR, PHP_LIST_SHARED_LIBADD)
  dnl   AC_DEFINE(HAVE_PHP_LISTLIB,1,[ ])
  dnl ],[
  dnl   AC_MSG_ERROR([wrong php_list lib version or lib not found])
  dnl ],[
  dnl   -L$PHP_LIST_DIR/$PHP_LIBDIR -lm
  dnl ])
  dnl
  dnl PHP_SUBST(PHP_LIST_SHARED_LIBADD)

  PHP_NEW_EXTENSION(php_list, php_list.c, $ext_shared)
fi
