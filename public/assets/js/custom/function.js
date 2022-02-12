function ajax_get_custom(array_param,url,callback){
    var param_url='&';
    var full_url = '';
    array_param.forEach(function(v,k){
        param_url+= k+"="+v;
    });
    full_url = url+ param_url;
    var http = XMLHttpRequest();
    http.open();
    http.send();
    http.close();
}
