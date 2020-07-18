const Functions = {
    formatPrice(price) {
        return parseFloat(price).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    },

    enableBtn(label,btn)  {
        btn.innerHTML = label;
        btn.removeAttribute('disabled');
    },

    disableBtn(label, btn)  {
        btn.innerHTML = label;
        btn.setAttribute('disabled','disabled');
    },

    isInt: function (value) {
        return !isNaN(value) && 
               parseInt(Number(value)) == value && 
               !isNaN(parseInt(value, 10));
    },

    setCookie(name,value,days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days*24*60*60*1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "")  + expires + "; path=/";
    },

    getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
          var c = ca[i];
          while (c.charAt(0) == ' ') {
            c = c.substring(1);
          }
          if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
          }
        }
        return "";
    },

    deleteCookie(name) {
        document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    },

}

export default Functions;