function listErrors (errors) 
{
	//alert("Listing Errors");
	console.log(errors);
	var list = document.createElement('ul');
	
	for (i = 0; i < errors.length; i++) {
		var err = document.createElement('li');
		err.appendChild(document.createTextNode(errors[i]));
		list.appendChild(err);
	}
	
	document.body.scrollTop = document.documentElement.scrollTop = 0;
	return list;
}
