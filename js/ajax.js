function Ajax(type, path) {
    this.type = type;
    this.path = path;
    this.files = [];
    this.isFiles = false;
    this.countFiles = 0;
    this.data = "";
    this.sendData = "";
    this.xhttp = "";
    this.callback = '';
    this.sendState = false;
    if (window.XMLHttpRequest){
        this.xhttp=new XMLHttpRequest();
    }
    else {
        this.xhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
}
Ajax.prototype = {
    setData: function (x) {
        this.sendData = x;
    },
    send: function (callback) {
        this.sendState = true;
        this.callback = callback;
        if (this.type == "POST") {
            this.xhttp.open("POST", this.path, true);
            this.xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            if (this.sendData.length || this.isFiles) {
                        if(this.sendData.length && (!this.isFiles || this.fileReader.readyState==0)) {
                            this.xhttp.send(this.sendData);
                        }
                        else if(this.isFiles && this.fileReader.readyState==2) {
                            if(this.sendData.length) this.sendData+='&';
                            this.xhttp.send(this.sendData+this.files);
                        }
                        else if(this.fileReader.readyState==1){
                            return''
                        }
                        else if (!this.sendData.length && !this.isFiles) {
                            this.xhttp.send();
                        }
                }
            else {
                this.xhttp.send();
            }
        }
        else if (this.type == "GET") {
            this.xhttp.open("GET", this.path, true);
            this.xhttp.send();
        }
        this.xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                callback(this.responseText);
            }
        }
    },
    setLocation: function (curLoc) {
        try {
            history.pushState(null, null, curLoc);
            return;
        } catch (e) {
        }
        location.hash = '#' + curLoc;
    },
    appendFile: function (name, file) {
        this.countFiles++;
        this.isFiles = true;
        this.fileReader = new FileReader();
            files = this.files;
            th = this;
         this.fileReader.onload = function (e) {
            if (th.files == '')
                th.files = name + '=' + e.target.result;
         else
             th.files += '&' + name + '=' + e.target.result;
         if(th.sendState)
            th.send(th.callback);
         };
         this.fileReader.readAsDataURL(file);
         }
}