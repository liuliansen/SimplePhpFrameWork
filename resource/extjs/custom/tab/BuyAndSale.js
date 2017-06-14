Ext.define('Ext.tab.BuyAndSale', {
    extend: 'Ext.tab.Panel',
    border:false,
    frame:false,
    activeTab: 0,
    loadCount:0,
    realodOver:function(){
        var _this = this;
        _this.loadCount++;
        if(_this.loadCount == 3) {
            _this.loadCount = 0;
            setTimeout(function () {
                _this.getData();
            }, 1000);
        }
    },
    getData:function(){
        var _this = this;
        _this.buyAndSellStore.load({
            callback:function(){
                _this.realodOver();
            }
        });
        _this.buyStore.load({
            callback:function(){
                _this.realodOver();
            }
        });
        _this.sellStore.load({
            callback:function(){
                _this.realodOver();
            }
        });
    },
    buyStore:Ext.create('Ext.store.BuyAndSell',{
        proxy: {
            type: 'ajax',
            url: JsHelper.buildUrl(HOST, RQ , 'KZCookie','getBuyAndSale')+'&type=buy',
            reader: {
                type: 'json',
                root: 'data'
            }
        }
    }),
    sellStore:Ext.create('Ext.store.BuyAndSell',{
        proxy: {
            type: 'ajax',
            url: JsHelper.buildUrl(HOST, RQ , 'KZCookie','getBuyAndSale')+'&type=sell',
            reader: {
                type: 'json',
                root: 'data'
            }
        }
    }),
    buyAndSellStore:Ext.create('Ext.store.BuyAndSell'),
    initComponent:function(){
        var tab = this;
        setTimeout(function () {
            tab.getData();
        }, 1000);
        tab.items = [{
            xtype:'grid',
            title:'买/卖',
            viewConfig : {
                loadMask : false
            },
            store:tab.buyAndSellStore,
            columns: [
                { text: '买/卖', dataIndex: 'typeText', align:'right',hideable : false,sortable :false,width:50 },
                { text: '价格', dataIndex: 'price', align:'right',hideable : false,sortable :false,width:120},
                { text: '数量', dataIndex: 'quantity', align:'right',hideable : false,sortable :false,width:130 },
                { text: '金额', dataIndex: 'amount' ,align:'right',hideable : false,sortable :false,flex: 1 },
            ],
            listeners:{
                itemcontextmenu: function( grid, record, item, index, e, eOpts ){
                    e.stopEvent();
                    Ext.create('Ext.menu.Menu', {
                        items: [{
                            text: '此价买入',
                            icon: HOST+'/resource/images/add.gif',
                            handler:function(){
                                Ext.create('Ext.window.Entrust',{
                                    title:'<span style="color:#951B1A;">买入</span>-委托',
                                    action:'buy',
                                    price:record.data.ori_price
                                });
                            }
                        },{
                            text: '此价卖出',
                            icon: HOST+'/resource/images/delete.png',
                            handler:function(){
                                Ext.create('Ext.window.Entrust',{
                                    title:'<span style="color:#85C98B;">卖出</span>-委托',
                                    action:'sell',
                                    price:record.data.ori_price
                                });
                            }
                        }]
                    }).showAt(e.getPoint());
                }
            }
        },
            {
                xtype:'grid',
                title:'买入',
                viewConfig : {
                    loadMask : false
                },
                store:tab.buyStore,
                columns: [
                    { text: '买/卖', dataIndex: 'typeText', align:'right',hideable : false,sortable :false,width:50 },
                    { text: '价格', dataIndex: 'price', align:'right',hideable : false,sortable :false,width:120},
                    { text: '数量', dataIndex: 'quantity', align:'right',hideable : false,sortable :false,width:130 },
                    { text: '金额', dataIndex: 'amount' ,align:'right',hideable : false,sortable :false,flex: 1 },
                ]
            },
            {
                xtype:'grid',
                title:'卖出',
                viewConfig : {
                    loadMask : false
                },
                store:tab.sellStore,
                columns: [
                    { text: '买/卖', dataIndex: 'typeText', align:'right',hideable : false,sortable :false,width:50 },
                    { text: '价格', dataIndex: 'price', align:'right',hideable : false,sortable :false,width:120},
                    { text: '数量', dataIndex: 'quantity', align:'right',hideable : false,sortable :false,width:130 },
                    { text: '金额', dataIndex: 'amount' ,align:'right',hideable : false,sortable :false,flex: 1 },
                ]
            }];
        tab.callParent(arguments);
    }

});
