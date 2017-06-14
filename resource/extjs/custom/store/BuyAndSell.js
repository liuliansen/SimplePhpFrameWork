Ext.define('Ext.store.BuyAndSell',{
    extend:'Ext.data.Store',
    fields: [
        {name:'type'},
        {name: 'typeText',convert:function(v,record){
            if(record.data.type == 'sell') {
                return '<span style="color:green">'+v+'</span>';
            }else{
                return '<span style="color:red">'+v+'<span>';
            }
        }},
        {name:'ori_price',mapping:'price'},
        {name: 'price',convert:function(v,record){

            if(record.data.type == 'sell') {
                return '<span style="color:green">'+v+'</span>';
            }else{
                return '<span style="color:red">'+v+'</span>';
            }
        }},
        {name: 'quantity',convert:function(v,record){
            if(record.data.type == 'sell') {
                return '<span style="color:green">'+v+'</span>';
            }else{
                return '<span style="color:red">'+v+'</span>';
            }
        }},
        {name: 'amount',convert:function(v,record){
            if(record.data.type == 'sell') {
                return '<span style="color:green">'+v+'</span>';
            }else{
                return '<span style="color:red">'+v+'</span>';
            }
        }},
    ],
    autoLoad:true,
    proxy: {
        type: 'ajax',
        url: JsHelper.buildUrl(HOST, RQ , 'KZCookie','getBuyAndSale'),
        reader: {
            type: 'json',
            root: 'data'
        }
    }
});