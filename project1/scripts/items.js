'use strict';

let form = document.querySelector('#addItemForm');
let showAddItem = document.querySelector('#showAddItem');
let cancelAddItem = document.querySelector('#cancelAddItem');
let checkboxList = document.querySelectorAll('input[name="complete"]');
let deleteItemList = document.querySelectorAll('.deleteItem');
let editItemList = document.querySelectorAll('.fa-pencil-square-o');
let cancelEditItemList = document.querySelectorAll('.cancelEditItem');
let editItemFormList = document.querySelectorAll('.editItemForm');
let assignUserList = document.querySelectorAll('.assignUser');
let cancelAssignUserList = document.querySelectorAll('.cancelAssignUser');
let assignUserFormList = document.querySelectorAll('.assignUserForm');

form.addEventListener('submit', addItem);
showAddItem.addEventListener('click', showAddItemHandler);
cancelAddItem.addEventListener('click', cancelAddItemHandler);

checkboxList.forEach(function(element) {
	element.addEventListener('click', updateItemComplete);
});

deleteItemList.forEach(function(element) {
	element.addEventListener('click', deleteItemHandler);
});

editItemList.forEach(function(element) {
	element.addEventListener('click', editItemHandler);
});

cancelEditItemList.forEach(function(element) {
	element.addEventListener('click', cancelEditItemHandler);
});

editItemFormList.forEach(function(element) {
	element.addEventListener('submit', editItemSubmitHandler);
});

assignUserList.forEach(function(element) {
	element.addEventListener('click', assignUserHandler);
});

cancelAssignUserList.forEach(function(element) {
	element.addEventListener('click', cancelAssignUserHandler);
});

assignUserFormList.forEach(function(element) {
	element.addEventListener('submit', assignUserSubmitHandler);
});


function addItem(event) {
	let id_list = document.querySelector('input[name=id]').value;
	let description = document.querySelector('input[name=description]').value;

	let request = new XMLHttpRequest();
	let DOMString = './actions/action_add_item.php?' + encodeForAjax({'id':id_list, 'description': description});
	request.open('get', DOMString, true);
	request.addEventListener('load', itemAdded);
	request.send();

	event.preventDefault();
}

function deleteItemHandler(event) {
	let itemID = event.target.id.substr(6); // getting clicked item's ID

	let request = new XMLHttpRequest();
	let DOMString = './actions/action_delete_item.php?' + encodeForAjax({'id':itemID});
	request.open('get', DOMString, true);
	request.addEventListener('load', itemDeleted);
	request.send();
}

function itemAdded() {
	let newItem = JSON.parse(this.responseText);
	let container = document.getElementById('items-list');
	let itemDiv = document.createElement('div');

	itemDiv.classList.add('item');
	itemDiv.id = 'item' + newItem.id;
	itemDiv.innerHTML = getItemHTML(newItem.id, newItem.description, newItem.dueDate);

	// Add event listeners to new item
	itemDiv.querySelector('.fa-pencil-square-o').addEventListener('click', editItemHandler);
	itemDiv.querySelector('.cancelEditItem').addEventListener('click', cancelEditItemHandler);
	itemDiv.querySelector('.deleteItem').addEventListener('click', deleteItemHandler);
	
	container.append(itemDiv);
}

function itemDeleted() {
	let itemID = this.responseText;

	if(itemID == -1)
		return;

	let item = document.getElementById('item' + itemID);
	item.parentNode.removeChild(item);
}

function showAddItemHandler(event) {
	form.classList.remove('hidden');
	showAddItem.classList.add('hidden');
}

function cancelAddItemHandler(event) {
	form.classList.add('hidden');
	showAddItem.classList.remove('hidden');
}

function editItemHandler(event) {
	let itemID = event.target.id.substr(4);
	let item = document.getElementById('item' + itemID);

	let left = item.querySelector('.item-left');
	let edit = item.querySelector('.item-edit');
	left.classList.add('hidden');
	edit.classList.remove('hidden');
}

function editItemSubmitHandler(event) {
	event.preventDefault();
	console.log(event.target);
	let editForm = event.target;
	let itemID = editForm.querySelector('input[name=itemID]').value;
	let newDescription = editForm.querySelector('input[name=editDescription]').value;
	let newDate = editForm.querySelector('input[name=editDate]').value;

	let DOMString = './actions/action_edit_item.php?' + encodeForAjax({'itemID':itemID, 'description': newDescription, 'dueDate': newDate});

	let request = new XMLHttpRequest();
	request.open('get', DOMString, true);
	request.addEventListener('load', editItemFinished);
	request.send();
}

function cancelEditItemHandler(event) {
	let itemEdit = event.target.parentNode.parentNode.parentNode;
	itemEdit.classList.add('hidden');

	let itemLeft = itemEdit.parentNode.querySelector('.item-left');
	itemLeft.classList.remove('hidden');
}

function assignUserHandler(event) {
	let itemID = event.target.id.substr(10);
	let item = document.getElementById('item' + itemID);

	let left = item.querySelector('.item-left');
	let user = item.querySelector('.item-user');
	left.classList.add('hidden');
	user.classList.remove('hidden');
}

function cancelAssignUserHandler(event) {
	let itemUser = event.target.parentNode.parentNode.parentNode;
	itemUser.classList.add('hidden');

	let itemLeft = itemUser.parentNode.querySelector('.item-left');
	itemLeft.classList.remove('hidden');
}

function assignUserSubmitHandler(event) {
	event.preventDefault();
	console.log(event.target);
	let editForm = event.target;
	let itemID = editForm.querySelector('input[name=itemID]').value;
	let assignedUser = editForm.querySelector('input[name=assignedUser]').value;

	let DOMString = './actions/action_assign_user.php?' + encodeForAjax({'itemID':itemID, 'assignedUser': assignedUser});

	let request = new XMLHttpRequest();
	request.open('get', DOMString, true);
	request.addEventListener('load', assignUserFinished);
	request.send();
}

function updateItemComplete(event) {
	event.preventDefault();
	let checkbox = event.target;
	let currentValue = checkbox.checked;
	let itemID = checkbox.id;

	let newValue = currentValue ? 1 : 0; //lolwut
	let DOMString = './actions/action_update_complete.php?' + encodeForAjax({'itemID':itemID, 'complete': newValue});

	let request = new XMLHttpRequest();
	request.open('get', DOMString, true);
	request.addEventListener('load', checkboxUpdated);
	request.send();
}

function checkboxUpdated() {
	let item = JSON.parse(this.responseText);
	setChecked(item.id, item.complete == 1);
}

function editItemFinished() {
	let newItem = JSON.parse(this.responseText);
	let itemID = newItem.id;
	let itemDiv = document.getElementById('item'+itemID);

	let description = itemDiv.querySelectorAll('.itemDescription');
	let dueDate = itemDiv.querySelectorAll('.itemDueDate');

	description.value = newItem.description;
	dueDate.value = newItem.dueDate;

	let itemEditArea = itemDiv.querySelector('.item-edit');
	itemEditArea.classList.add('hidden');

	let itemInfoArea = itemDiv.querySelector('.item-left');
	itemInfoArea.classList.remove('hidden');
}

function assignUserFinished() {
	let newItem = JSON.parse(this.responseText);
	let itemID = newItem.id;
	let itemDiv = document.getElementById('item'+itemID);
	let assignUser = document.getElementById('assignUser'+itemID);

	assignUser.classList.remove('fa-user-plus');
	assignUser.classList.add('fa-user');

	let itemUserArea = itemDiv.querySelector('.item-user');
	itemUserArea.classList.add('hidden');

	let itemInfoArea = itemDiv.querySelector('.item-left');
	itemInfoArea.classList.remove('hidden');
}

function setChecked(id, value) {
	let checkbox = document.getElementById(id);
	checkbox.checked = value;
}

function getItemHTML(id, description, dueDate) {
	return '<div class="item-left">'+
			'<input type="checkbox" id="' + id + '" name="complete">' +
			'<span class="itemDescription">' + description + '</span>'+
			'<span clas="itemDueDate">' + dueDate + '</span>' +
		'</div>	<div class="item-edit hidden"><form class="editItemForm"> <div class="flex-equal">'+
			'<input type="hidden" name="itemID" value="' + id + '"><div>'+
			'<label for="editDescription">Description</label>'+
			'<input type="text" name="editDescription" value="' + description+'" required></div>'+
		'<div><label for="editDate">Due Date</label>'+
			'<input type="date" name="editDate" value="' + dueDate +
			'" required></div></div><div><input class="button-primary" type="submit" value="Save">'+
			'<a class="button cancelEditItem">Cancel</a> </div></form></div><div class="item-right">'+
			'<span><i id="assignUser'+ id + '" class="fa fa-user-plus"></i></span>'+
			'<span><i id="edit'+ id + '" class="fa fa-pencil-square-o"></i></span>'+
			'<span><i id="delete'+ id + '" class="fa fa-trash deleteItem"></i></span>' +'</div>';
}

function encodeForAjax(data) {
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&');
}
