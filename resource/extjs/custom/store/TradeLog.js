Ext.define('Ext.store.TradeLog',{
    extend:'Ext.data.Store',
    fields: [
        {name:'type'},
        {name:'addtime'},
        {name: 'typeText',convert:function(v,record){
            if(record.data.type == '2') {
                return '<span style="color:green">'+v+'</span>';
            }else{
                return '<span style="color:red">'+v+'<span>';
            }
        }},
        {name: 'price',convert:function(v,record){
            if(record.data.type == '2') {
                return '<span style="color:green">'+v+'</span>';
            }else{
                return '<span style="color:red">'+v+'</span>';
            }
        }},
        {name: 'quantity',convert:function(v,record){
            if(record.data.type == '2') {
                return '<span style="color:green">'+v+'</span>';
            }else{
                return '<span style="color:red">'+v+'</span>';
            }
        }},
        {name: 'amount',convert:function(v,record){
            if(record.data.type == '2') {
                return '<span style="color:green">'+v+'</span>';
            }else{
                return '<span style="color:red">'+v+'</span>';
            }
        }},
    ],
    autoLoad:true,
    proxy: {
        type: 'ajax',
        url: JsHelper.buildUrl(HOST, RQ , 'KZCookie','getTradeLog'),
        reader: {
            type: 'json',
            root: 'data'
        }
    }
});