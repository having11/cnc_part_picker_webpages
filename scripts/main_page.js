var latestOption = "";
var latestQuery = "";

var queryDict = {}
location.search.substr(1).split("&").forEach(function(item) {queryDict[item.split("=")[0]] = item.split("=")[1]})

var username = queryDict['username'];
console.log(username);

function welcome_user(name){
	document.getElementById("user_info").innerHTML = '<p>Welcome, '+name+'.</p><a href="/index.html">Logout</a>'
}

function showItem(type, str){
	latestOption = type;
	latestQuery = str;
			if (str==""){
				document.getElementById("txtHint").innerHTML = "";
				return;
			}
			else {
				if(window.XMLHttpRequest){
					xmlhttp = new XMLHttpRequest();
				}
				xmlhttp.onreadystatechange = function(){
					if(this.readyState == 4 && this.status == 200){
						document.getElementById("txtHint").innerHTML = this.responseText;
					}
				};
				xmlhttp.open("GET","getpart.php?q="+type+','+str+','+username,true);
				xmlhttp.send();
			}
		}
function quick_add(selection,str){
	if(str==""){
		document.getElementById("quick_added").innerHTML = "";
		return;
	}
	else{
		if(window.XMLHttpRequest){
			xmlhttp = new XMLHttpRequest();
		}
		xmlhttp.onreadystatechange = function(){
			if(this.readyState==4 && this.status==200){
				document.getElementById("quick_added").innerHTML = this.responseText;
				
			}
		};
		xmlhttp.open("GET","getpart.php?q=quick_add,"+selection+','+str+','+username,true);
		xmlhttp.send();
		document.getElementById("id_input_text").value = "";
		var http = new XMLHttpRequest();
		var postdata = "?id="+str;
		http.open("GET","http://127.0.0.1:5000/"+postdata, true);
		http.send();
	}
	//alert(latestOption+','+latestQuery);
	showItem(latestOption, latestQuery);
			
}
function change_parts(name, str, choice, category){
	if(str==""){
		document.getElementById("response").innerHTML = "";
		return;
	}
	else{
	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}
		xmlhttp.onreadystatechange = function(){
			if(this.readyState==4&&this.status==200){
				document.getElementById("response").innerHTML = this.responseText;
				load_parts_from_cat(category);
			}
		};
		xmlhttp.open("GET","retrieve.php?q=change_amt,"+name+','+str+','+choice+','+category+','+username,true);
		document.getElementById("change_add_txt").value = "";
		xmlhttp.send();
		var http = new XMLHttpRequest();
		var postdata = "?name="+name;
		http.open("GET","http://127.0.0.1:5000/"+postdata, true);
		http.send();
		console.log("http://127.0.0.1:5000/"+postdata);
	}
	load_parts_from_cat(document.getElementById("drop_down_id").value);
	console.log(document.getElementById("drop_down_id").value);
	showItem(latestOption, latestQuery);
}

function load_parts_from_cat(category){
	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}
		xmlhttp.onreadystatechange = function(){
			if(this.readyState==4&&this.status==200){
				document.getElementById("change_parts_from_cat").innerHTML = this.responseText;
			}
		};
		xmlhttp.open("GET","retrieve.php?q=load_parts,"+category+','+username,true);
		xmlhttp.send();
	}

function delete_category(category_name){
	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}
	xmlhttp.onreadystatechange = function(){
	if(this.readyState==4&&this.status==200){
		document.getElementById("response").innerHTML = "Removed the "+category_name+" category and all associated parts";
		load_cats("change_parts_cats","true");
		load_cats("cat_list","false");
	}
	};
xmlhttp.open("GET","retrieve.php?q=remove_cat"+','+username+','+category_name,true);
xmlhttp.send();
}

function load_cats(id_name,is_change_parts){
	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}
	xmlhttp.onreadystatechange = function(){
	if(this.readyState==4&&this.status==200){
		document.getElementById(id_name).innerHTML = this.responseText;
	}
	};
xmlhttp.open("GET","retrieve.php?q=load_cats"+','+username+','+is_change_parts,true);
xmlhttp.send();
}

function load_large_table(){
	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}
	xmlhttp.onreadystatechange = function(){
		if(this.readyState==4&&this.status){
			document.getElementById("large_table").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET", "large_table_load.php?username="+ username,true);
	xmlhttp.send();
}

function add_category(name){
	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}
	xmlhttp.onreadystatechange = function(){
		if(this.readyState==4&&this.status){
			document.getElementById("response").innerHTML = "Added new category";
			document.getElementById("add_cat").value="";
			load_cats("change_parts_cats","true");
			load_cats("cat_list","false");
		}
	};
	xmlhttp.open("GET", "retrieve.php?q=add_cat,"+name+','+username,true);
	xmlhttp.send();
}

var refresh = setInterval(function(){
	load_large_table();
},1000);