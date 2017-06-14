Ext.define('Ext.window.Entrust',{
    extend:'Ext.window.Window',
    width: 400,
    autoShow:true,
    modal : true,
    price:'',
    initComponent:function(){
        var _this = this;
        _this.items =
            Ext.create('Ext.form.Panel', {
                region:'center',
                frame:true,
                bodyPadding: '0 10 20 10',
                border:false,
                frame:false,
                url: JsHelper.buildUrl(HOST, RQ , 'Entrust','entrust'),

                layout: 'anchor',
                defaults: {
                    anchor: '100%',
                    labelWidth : 80,
                    margin:'20 0 0 0'
                },
                items: [{
                    xtype: 'hidden',
                    name: 'type',
                    value: _this.action == 'buy' ? 1:2
                },{
                    xtype: 'displayfield',
                    fieldLabel: '可用资金',
                    name: 'availAmount',
                    value:0
                },{
                    xtype: 'displayfield',
                    fieldLabel: (_this.action == 'buy'?'可买':'可卖')+' XUP',
                    name: 'max_quantity',
                    value:0
                },{
                    xtype: 'numberfield',
                    maxValue: 99999,
                    minValue: 0.1,
                    fieldLabel: (_this.action == 'buy'?'买入':'卖出')+'价格',
                    name: 'price',
                    allowBlank: false,
                    value:_this.price
                },{
                    xtype: 'numberfield',
                    maxValue: 99999,
                    minValue: 0.0001,
                    fieldLabel: (_this.action == 'buy'?'买入':'卖出')+'数量',
                    name: 'quantity'
                }],

                buttons: [{
                    text: '重置',
                    handler: function() {
                        this.up('form').getForm().reset();
                    }
                }, {
                    text: '委托',
                    formBind: true,
                    disabled: true,
                    handler: function() {
                        var form = this.up('form').getForm();
                        if (form.isValid()) {
                            var mask = new Ext.LoadMask(_this, {msg:"正在提交..."});
                            mask.show();
                            form.submit({
                                success: function(form, action) {
                                    mask.hide();
                                    _this.close();
                                    Ext.Msg.alert('委托成功', '委托成功,请到委托列表查看');
                                },
                                failure: function(form, action) {
                                    mask.hide();
                                    Ext.Msg.alert('委托失败', action.result.msg);
                                }
                            });
                        }
                    }
                }]
            });
        _this.callParent(arguments);
    },
    listeners:{
        show:function(wind){
            wind.getEntrustAndUsercoin();
        }
    },

    getEntrustAndUsercoin:function(){
        var _this = this;
        var mask = new Ext.LoadMask(_this, {msg:"财务数据读取中..."});
        mask.show();
        Ext.Ajax.request({
            url: JsHelper.buildUrl(HOST, RQ , 'Entrust','getUserCoin'),
            success:function(response){
                try {
                    var data = Ext.decode(response.responseText);
                    if(data.success) {
                        var usercoin= data.usercoin;
                        var form = _this.down('form').getForm();
                        form.findField('availAmount').setValue(usercoin.cny);
                        if (_this.action == 'buy') {
                            var max = (parseFloat(usercoin.cny)/_this.price).toFixed(4);
                            form.findField('max_quantity').setValue(max);
                            form.findField('quantity').maxValue = max
                        }else{
                            form.findField('max_quantity').setValue(usercoin.xnb);
                            form.findField('quantity').maxValue = parseFloat(usercoin.xnb);
                        }
                    }else{
                        alert(data.msg);
                    }
                }catch (e){}
            },
            callback:function(options ,success ,response ){
                mask.hide()
                if(!success) {
                    alert('获取酷赚财务数据失败');
                }
            }
        });
    }
});