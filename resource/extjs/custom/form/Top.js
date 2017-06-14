Ext.define('Ext.form.Top',{
    extend:'Ext.form.Panel',
    border:false,
    frame:false,
    layout:'column',
    bodyStyle:'font-size:20px;font-weight:bold;background:#BAD1F6;padding:7px 0 0 10px;',

    defaults: {
        columnWidth: 0.14,
        labelWidth: 50
    },
    defaultType: 'displayfield',
    items: [{
        fieldLabel: '最新成交价',
        labelWidth: 80,
        name: 'new_price'
    },{
        fieldLabel: '涨跌',
        name: 'change'
    },{
        fieldLabel: '最高价',
        name: 'max_price'
    },{
        fieldLabel: '最低价',
        name: 'min_price'
    },{
        fieldLabel: '买一',
        name: 'buy_price'
    },{
        fieldLabel: '卖一',
        name: 'sell_price'
    },{
        fieldLabel: '成交量',
        name: 'volume'
    }],
    loadData:function(){
        var _this = this;
        Ext.Ajax.request({
            url: JsHelper.buildUrl(HOST, RQ , 'KZCookie','getTop'),
            callback:function(options ,success ,response ){
                try {
                    var data = Ext.decode(response.responseText);
                    _this.getForm().setValues(data.data);
                }catch (e){}
                setTimeout(function () {
                    _this.loadData();
                }, 1500);
            }
        });
    },
    initComponent:function(){
        this.loadData();
        this.callParent(arguments);
    }
});