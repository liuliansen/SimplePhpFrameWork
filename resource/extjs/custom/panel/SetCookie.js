Ext.define('Ext.panel.SetCookie',{
    extend:'Ext.panel.Panel',
    layout: 'border',
    border:false,
    frame:false,
    bodyStyle:'background:#fff;',
    initComponent:function(){
        var pricePanel = this;
        pricePanel.items = [
            Ext.create('Ext.form.Panel', {
                region:'center',
                frame:true,
                bodyPadding: 20,
                url: JsHelper.buildUrl(HOST, RQ , 'KZCookie','save'),

                layout: 'anchor',
                defaults: {
                    anchor: '100%',
                    labelWidth : 120,
                    margin:'20 0 0 0'
                },

                defaultType: 'textfield',
                items: [{
                    fieldLabel: 'PHPSESSID',
                    name: 'PHPSESSID',
                    allowBlank: false
                },{
                    fieldLabel: 'cookie_username',
                    name: 'cookie_username'
                },{
                    fieldLabel: 'yd_cookie',
                    name: 'yd_cookie',
                    // allowBlank: false
                },{
                    fieldLabel: 'think_language',
                    name: 'think_language'
                },{
                    fieldLabel: '_ydclearance',
                    name: '_ydclearance'
                },{
                    fieldLabel: 'yd_srvbl',
                    name: 'yd_srvbl'
                }],

                buttons: [{
                    text: '重置',
                    handler: function() {
                        this.up('form').getForm().reset();
                    }
                }, {
                    text: '保存',
                    formBind: true, //only enabled once the form is valid
                    disabled: true,
                    handler: function() {
                        var form = this.up('form').getForm();
                        if (form.isValid()) {
                            form.submit({
                                success: function(form, action) {
                                    Ext.Msg.alert('Success', action.result.msg);
                                },
                                failure: function(form, action) {
                                    Ext.Msg.alert('Failed', action.result.msg);
                                }
                            });
                        }
                    }
                }]
            }),
            {
                region:'north',
                height:'10%',
                border:false,
                frame:false,
            },{
                region:'south',
                height:'50%',
                border:false,
                frame:false,
            },{
                region:'west',
                width:'30%',
                border:false,
                frame:false,
            },{
                region:'east',
                width:'30%',
                border:false,
                frame:false,
            }];

        pricePanel.callParent(arguments);
    }
});