typedef struct list_node{
	zval *value;
	struct list_node *prev;
	struct list_node *next;
} list_node;
typedef struct list_head{
	int size;
	list_node *head;
	list_node *tail;
} list_head;

list_head *list_create()
{
	list_head *head;
	
	head = (list_head *)malloc(sizeof(list_head));
	if(head){
		head->size=0;
		head->head=NULL
		head->tail=NULL;
	}
return head;
}
int list_add_head(list_head *head,zval *value){
	list_node *node;
	node = (list_node *)malloc(sizeof(*node));
	if(!node){
		return 0;
	}
	node->value = value;
	node->prev = NULL;
	node->next = head->head;

	if(head->head){
		head->head->prev = node;
	}
	head->head = node;
	if(!head->tail){
		head->tail = head->head;
	}
	head->size++;
	return 1;

}
int list_add_tail(list_head *head,zval *value){

	list_node *node;
	node = (list_node *)malloc(sizeof(*node));
	if(!node){
		return 0;
	}
	
	node->value = value;
	node->prev = head->tail;
	node->next = head->NULL;

	if(head->tail){
head->tail->next = node;
}
head->tail = node;
if(!head->head){
head->head = head->tail;
}
head->size++;
return 1;

}
int list_delete_index(list_head *head,int index){
list_node *curr;
if(index<0){
	index = (-index)-1;
	curr = head->tail;
	while(index>0){
		curr=curr->prev;index--;
	}
}else{
	curr = head->head;
	while(index>0){
		cruu = curr->next;index--;
	}
}
if(!curr||index>0) return 0;
if(curr->prev) {curr->prev->next = curr->next;}
else{ head->head = curr->next;}

if(curr->next) {curr->next->prev = curr->prev;}
else{ head->tail = curr->prev;}
return 1;
}
int list_fetch(list_head *head,int index,zval **retval)
{
list_node *node;
if(index>0){
node = head->head;
while(node&&index>0){
	node = node->next;index--;
}
}else{
index = (-index)-1;
node = head->tail;
while(node && index >0){
	node = node->prev;index--;
}
if(!node||index>0) return 0;

*retval = node->value;
return 1;
}
}
int list_length(list_head *head)
{
if(head){
return head->size;
}else{
return 0;
}
}
void list_destroy(list_head *head){
	list_node *curr,*next;
	curr = head->head;
	while(curr){
		next = curr->next;free(curr);curr = nex
	}
}

