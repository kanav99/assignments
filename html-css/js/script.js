function get_page(x) {
	var page;
	var url;
	if(x === "a") {
		page = "about.html";
		url = "about";
	}
	else if(x === "s"){
		page = "skills.html";
		url = "skills";
	}
	else if(x === "c") {
		page = "contact.html";
		url = "contact";
	}
	var xhr = new XMLHttpRequest;
	xhr.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
            document.getElementById("main").innerHTML = this.responseText;
            history.pushState(null, "" , url);
        }
	}
	xhr.open("GET" , page , true);
	xhr.send();
}
get_page("a");