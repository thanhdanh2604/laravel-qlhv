

function ajax_get_custom(object_param,url){
    var param_url='';
    var full_url = '';
    for (const key in object_param) {
        if (Object.hasOwnProperty.call(object_param, key)) {
            param_url+= "&"+key +"="+object_param[key];
        }
    }
    var new_param_url = '?'+param_url.slice(1);
    full_url = url+ new_param_url;
    var http = new XMLHttpRequest();
    http.onload = function(){
        respon = JSON.parse(this.responseText);
        if(respon.status=="success"){
            // action_onload_ajax_delete(idelement);
            // alert(this.responseText.status);
            location.reload();
        }
        if(respon.status=="false"){
            console.error('Lỗi!');
        }
    };
    http.open("GET",full_url);
    http.send();
}

