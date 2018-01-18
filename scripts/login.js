function login(username, password){
	var instruction_id = "login_hint_text";
	if(username=="" || password==""){
		
		document.getElementById(instruction_id).innerHTML = "Username or password empty";
	}
	else{
		if(window.XMLHttpRequest){
			xmlhttp = new XMLHttpRequest();
		}
		xmlhttp.onreadystatechange = function(){
			if(this.readyState==4 && this.status==200){
				if(this.responseText=="correct"){
					/*document.getElementById(instruction_id).innerHTML = this.responseText;*/
					window.location.href = "/main_page.html?username="+username;
				}
				else{
					document.getElementById(instruction_id).innerHTML = "Sorry, username or password is incorrect";
				}
			}
		};
		xmlhttp.open("GET","login.php?q="+username+','+password,true);
		xmlhttp.send();
	}
}

function check_passwords_same(pass2){
	var pass1 = document.getElementById("new_user_pass").value;
	if(pass1 !== pass2){
		document.getElementById("signup_hint_text").innerHTML = "Passwords do not match"
		return false;
	}
	else{
		document.getElementById("signup_hint_text").innerHTML = "";
		return true;
	}
}

function check_password_contain(pass){
	if(/[^a-zA-Z0-9]/.test(pass)){
		document.getElementById("signup_hint_text").innerHTML = "Password can only contain alphanumeric characters";
		return false;
	}
	else{
		document.getElementById("signup_hint_text").innerHTML = "";
		return true;
	}
}

function signup(username,password,password2){
	if(check_passwords_same(password2) && check_password_contain(password)){
		if(window.XMLHttpRequest){
			xmlhttp = new XMLHttpRequest();
		}
		xmlhttp.onreadystatechange = function(){
			if(this.readyState==4 && this.status==200){
				console.log(this.responseText);
				if(this.responseText=="created"){
					/*document.getElementById("signup_hint_text").innerHTML = "New user account created";*/
					login(username,password);
				}
				else{
					document.getElementById("signup_hint_text").innerHTML = "Sorry, account already exists";
				}
			}
		};
		xmlhttp.open("GET","login.php?q="+"new,"+username+','+password,true);
		xmlhttp.send();
	}
	
}