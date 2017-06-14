

JsHelper = {
    parseJSON : function(jsonStr){
        try{
            return $.parseJSON(jsonStr);
        }catch (e) {
            return e.message;
        }
    },
    buildUrl: function(host,rq,ctrl,action) {
        return host+'/index.php?'+rq+'='+ctrl+(action ? '/'+action : '');
    }
};