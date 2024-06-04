document.getElementById(eIndex(0)).onclick = () => {    // username
    checkContent(0, /[一-龠]/);
}

document.getElementById(eIndex(1)).onclick = () => {    // userid
    checkContent(1, /[一-龠]/);
}

document.getElementById(eIndex(2)).onclick = () => {    // password
    checkContent(2, /^([a-zA-Z0-9]{8,})$/);
}

document.getElementById(eIndex(3)).onclick = () => {    // password2
    checkContent(3, /[一-龠]/);
}

document.getElementById(eIndex(4)).onclick = () => {    // mailaddress
    checkContent(4, /^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@{1}[A-Za-z0-9_.-]{1,}\.[A-Za-z0-9]{1,}$/);
}

document.getElementById(eIndex(5)).onclick = () => {    // birthday
    
}

document.getElementById(eIndex(6)).onclick = () => {    // lastname
    checkContent(6, /[一-龠]/);
}

document.getElementById(eIndex(7)).onclick = () => {    // firstname
    checkContent(7, /[一-龠]/);
}

document.getElementById(eIndex(8)).onclick = () => {    // postnumber
    checkContent(8, /[一-龠]/);
}

document.getElementById(eIndex(9)).onclick = () => {    //address
    checkContent(9, /[一-龠]/);
}

document.getElementById(eIndex(10)).onclick = () => {   //phonenumber
    checkContent(10, /[一-龠]/);
}




document.getElementById("confirm").onclick = function() {
    const username = document.getElementById("username").value;
    const userid = document.getElementById("userid").value;
    const password = document.getElementById("password").value;
    const password2 = document.getElementById("password2").value;
    const email = document.getElementById("email").value;
    const lastname = document.getElementById("lastname").value;
    const firstname = document.getElementById("firstname").value;
    const postnumber = document.getElementById("postnumber").value;
    const address = document.getElementById("address").value;
    const phonenumber = document.getElementById("phonenumber").value;
    const birthday = document.getElementById("birthday").value;

    var flag = 0;
    if(username.length == 0){flag = 1;}
    if(userid.length == 0){ flag = 1; }
    if(mail.length == 0){ flag = 1; }
    if(pass.length == 0){ flag = 1; }
    if(repass.length == 0){ flag = 1; }

    if(flag == 1){ alert('必須項目が未記入の箇所があります'); return false; }
    else{
        flag_chk = 0;

        var regexp = /[一-龠]/;
        if(regexp.test(name) != true){ document.getElementById('name_chk').style.display = "block"; flag_chk = 1; }
        else{ document.getElementById('name_chk').style.display = "none"; }

        var regexp = /^[\u{3000}-\u{301C}\u{3041}-\u{3093}\u{309B}-\u{309E}]+$/mu;
        if(regexp.test(name_huri) != true){ document.getElementById('name_huri_chk').style.display = "block"; flag_chk = 1; }
        else{ document.getElementById('name_huri_chk').style.display = "none"; }

        var regexp = /^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@{1}[A-Za-z0-9_.-]{1,}\.[A-Za-z0-9]{1,}$/;
        if(regexp.test(mail) != true){ document.getElementById('mail_chk').style.display = "block"; flag_chk = 1; }
        else{ document.getElementById('mail_chk').style.display = "none"; }

        var regexp = /^([a-zA-Z0-9]{8,})$/;
        if(regexp.test(pass) != true){ document.getElementById('pass_chk').style.display = "block"; flag_chk = 1; }
        else{ document.getElementById('pass_chk').style.display = "none"; }

        if(pass != repass){ document.getElementById('repass_chk').style.display = "block"; flag_chk = 1; }
        else{ document.getElementById('repass_chk').style.display = "none"; }

        var regexp = /^\d{7}$/;
        if(regexp.test(yuubin) != true){ document.getElementById('yuubin_chk').style.display = "block"; flag_chk = 1; }
        else{ document.getElementById('yuubin_chk').style.display = "none"; }

        var regexp = /^(0{1}\d{9,10})$/;
        if(regexp.test(phone) != true){ document.getElementById('phone_chk').style.display = "block"; flag_chk = 1; }
        else{ document.getElementById('phone_chk').style.display = "none"; }

        if(flag_chk == 1){ return false; }
        else{ return ture; }
    }
};

function eIndex (int) {
    const enumIndex = [
        "username",
        "userid",
        "password",
        "password2",
        "email",
        "lastname",
        "firstname",
        "postnumber",
        "address",
        "phonenumber",
        "birthday",
    ];

    return enumIndex[int];
}

function checkContent(indexnum, regexp) {
    const content = document.getElementById(eIndex()).value;
    id = enumIndex(indexnum) + "_chk";
    
    if (regexp.test(content) != true) {
        document.getElementById(id).style.display = "block";
        return false;
    } else {
        document.getElementById(id).style.display = "none";
        return true;
    }
};