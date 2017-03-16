//interhome的库存小于5 更改状态还没做
//x站buynow跳转登陆页面 没做
define(['jquery'],function($){
var filterAttr = {
    filter : null,
    init : function(opts){
        var options = $.extend({
                attrBox         : '.attrBox',        //属性ul的class
                attrBoxLi       : '.attrBox li',        //属性ul的class
                dataKey         : 'data_key',       //属性dataKey
                dataValue       : 'data-attr-value',//属性datavalue
                dataId          : 'data-attr-id',   //属性dataID
                activeClass     : 'active',        //选中属性
                forbidClass     : 'invalid',       //不能选择的属性
                forbidden       : 'forbidden',     //按钮不能选择样式
                skuTxtID        : '.sku',     //title后面sku
                btnName         : 'p.attribute_name',//属性类  比如color size
                btnNameWhouse   : 'whouse',
                regular_price   : '#price',    //原价class
                productID       : '#uid',
                hoverImg        : '.hoverBig .cloud-zoom img',
                titleChange     : '.proInf h1'                           //小购物车数量
        },opts);
        this.filter = {
            selected        : null,          //当前选中的属性组合
            curr_sku        : null,          //当前选中的sku
            sku_find        : true,
            events : function(){
                var _this = this;
                $(options.attrBox).children().click(function(){
                    var thisBox = $(this).parent();
                    var dataVal = $(this).attr(options.dataValue);
                    var dataKey = $(this).parents(options.attrBox).prev(options.btnName).attr(options.dataKey);
                    if(!$(this).hasClass(options.forbidClass) && !$(this).hasClass(options.activeClass))
                    {
                        $(this).addClass(options.activeClass).siblings().removeClass(options.activeClass);
                        if(dataKey == '颜色'){
                            //_this.ImageSwitching(dataVal);////////******切换图片******/////////
                            //thisBox.find('.cloud-zoom').CloudZoom();
                        }
                        var click_attr_name = dataKey;
                        _this.closeAttr(click_attr_name);
                    }
                })
                ///////////*******鼠标经过换图片********//////////
                $(document).on("mouseover",options.attrBoxLi,function(){
                    if(!$(this).hasClass(options.forbidClass))
                    {
                        var hoverImgs = $(options.hoverImg);
                        var thisPrev = $(this).parent().prev(options.btnName);
                        var dataKey  = thisPrev.attr(options.dataKey);
                        var color    = $(this).attr(options.dataValue);
                        if(!$(this).hasClass(options.activeClass))
                        {
                            if(dataKey == 'color'){
                               // _this.hoverImg(color,hoverImgs);
                            }
                        }
                        thisPrev.children("b").text(color);
                    }
                })
                $(document).on("mouseout",options.attrBoxLi,function(){
                    if($(this).siblings("."+options.activeClass).length == 1){
                        var thisPrev = $(this).parent().prev(options.btnName);
                        var hoverImgs = $(options.hoverImg);
                        var color = $(this).siblings("."+options.activeClass).attr(options.dataValue);
                        var active = $(".thumbImg_list .cpActive a").attr("href");
                        thisPrev.children("b").text(color);
                        hoverImgs.attr("src",active);
                    }
                })
            },
            hoverImg : function(color,hoverImgs){//根据颜色属性找图片
                var imglist  = this.extractImg(mainContent,color);
                var titleImg = this.extractTitleImg(imglist);
                $.each(imglist,function(key,value){
                    hoverImgs.attr("src","");
                    hoverImgs.attr("src","^^^");
                    return false;
                })
            },
            extractImg : function(productMainCoteng,color){
                var mainC = productMainCoteng;
                var imglist = '';
                $.each(mainC,function(key,value){
                    $.each(value.data,function(j,attributeValue){
                        if(value.data.color == color){
                            for(var i = 0, _len = value.imgList.length; i < _len; i++){
                                if (value.imgList[i]['isMain'] == true) {
                                    var _temp = value.imgList[0];
                                    value.imgList[0] = value.imgList[i];
                                    value.imgList[i] = _temp;
                                }
                            }
                            imglist = value.imgList;
                            return false;
                        }
                    });
                });
                if(imglist){
                    return imglist;
                }
                return false;
            },
            extractTitleImg : function(imglist){
                // 功能：循环提取相关颜色主图
                // 参数：imglist为上面循环所得到的变量名      
                var mainC = imglist;
                var imgUrl = '';
                $.each(mainC,function(key,value){
                    if(value.isMain == true){
                        imgUrl = value.imgUrl;
                        return false;
                    }
                });
                if(imgUrl){
                    return imgUrl;
                }
                return false;
            },
            ImageSwitching : function(dataVal){//详情页已经改为页面跳转 但是列表页还需要
                var htmls      = '';
                var imgHtml    = '';
                var imglist    = this.extractImg(mainContent,dataVal);
                var titleImg   = this.extractTitleImg(imglist);
                var imgHtml    = {
                    eachs : function(zoom,value){
                         return '<li class="moveList lineBlock"><a rel="useZoom: \''+ zoom +'\', smallImage: \'\'" class="cloud-zoom-gallery" href=""><img src="" class="zoom-tiny-image"></a></li>';
                    }
                }
                $.each(imglist,function(key,value){
                    htmls += imgHtml.eachs('zoom1',value);
                });
                
                $(".thumbImg_list").html(htmls)
                $(".hoverBig").find(".cloud-zoom").attr('href',"").children('img').attr('src',"");
                $("#smallClickUrl,.thumbImg_items").find("li").eq(0).addClass('cpActive');
                
                $('.cloud-zoom-click,.cloud-zoom,.cloud-zoom-gallery').CloudZoom();
            },
            closeAttr : function(click_attr_name){
                var attrBox = $(options.attrBox);
                this.filterSku();
                //循环每个属性组合
                for (var d = 0; d < attrBox.length; d++) 
                {
                    var attr_name_btn  = attrBox.eq(d).prev(options.btnName).attr(options.dataKey);
                    var attr_value_btn = attrBox.eq(d).children();
                    if(attr_name_btn != (click_attr_name == undefined ? '' : click_attr_name))
                    {
                        //计算出剩余的sku
                        var skus = new Array();
                        var del = 0;
                        for (var u = 0; u < mainContent.length; u++) 
                        {
                            mainContent[u].isDel = 0;
                            skus.push(mainContent[u]);
                        }
                        for (var i = 0; i < this.selected.length; i++) 
                        {
                            var selected_name   = this.selected[i].attr_name;
                            var selected_value  = this.selected[i].attr_value;
                            if (selected_name != attr_name_btn) 
                            {
                                for (var j in mainContent)
                                {
                                    var is_sku_exist = false;
                                    var whouse1     = mainContent[j].whouse;
                                    var maps1   = mainContent[j].data;
                                    if (selected_name == options.btnNameWhouse) 
                                    {
                                        for(var w in whouse1)
                                        {
                                            if(w == selected_value)
                                            {
                                                is_sku_exist = true;
                                            }
                                        }
                                    }
                                    else
                                    {
                                        for(var m in maps1)
                                        {
                                            if (selected_name == m && selected_value == maps1[m]) 
                                            {
                                                is_sku_exist = true;
                                            }
                                        }
                                    }
                                    if(!is_sku_exist)
                                    {
                                        skus[j].isDel = 1;
                                    }
                                }
                            }
                        }
                        //循环每个按钮
                        for (var k = 0; k < attr_value_btn.length; k++)
                        {
                            var btn = attr_value_btn.eq(k);
                            this.forbidSelect(btn, skus,attr_name_btn);
                        }
                    }
                }
            },
            filterSku : function(){
                var n = 0;
                var attrBox = $(options.attrBox);
                curr_list = new Array();
                this.getAttrValue(attrBox);
                if(attrBox.length > 1){
                    for (var j = 0; j < mainContent.length; j++) 
                    {
                        var flag = false;
                        var sum = 0;//符合当前sku条件的属性值个数
                        for (var q = 0; q < this.selected.length; q++) 
                        {
                            var selected_name  = this.selected[q].attr_name;
                            var selected_value = this.selected[q].attr_value;
                            if (selected_name == options.btnNameWhouse) 
                            {
                                var whouse = mainContent[j].whouse;
                                for(var i in whouse)
                                {
                                    if (i == selected_value) 
                                    {
                                       sum++;break;
                                    }
                                }
                            }
                            else
                            {
                                var attributeMap = mainContent[j].data;
                                for(var i in attributeMap)
                                {
                                    if(i == selected_name && attributeMap[i] == selected_value)//循环每一个产品 看里面是否有选择的全部属性
                                    {
                                        sum++;break;
                                    }
                                }
                            }
                        }
                        if (sum == q) //把匹配的留下
                        {
                            n++;//确定sku 看是否唯一  如果n=1则确定
                            curr_list.push(mainContent[j]);
                        }
                    }
                }else{
                    var attr_value = attrBox.find('.'+options.activeClass).attr(options.dataValue);
                    for (var j in mainContent)
                    {
                        if(mainContent[j].sku == this.productSku()){
                            var whouse1 = mainContent[j].whouse;
                            for(var w in whouse1)
                            {
                                if(whouse1[attr_value]){
                                    curr_list.push(mainContent[j]);
                                    this.curr_sku = curr_list[0];
                                    return;
                                }
                            }
                        }
                    }
                }
                //如果sku被确定，获取clistingid
                if(n == 1) 
                {
                    this.sku_find = true;
                    this.curr_sku = curr_list[0];
                    $(options.skuTxtID).text(this.curr_sku.sku);
                    $(options.regular_price).text(this.curr_sku.disprice);
                    $(options.productID).val(this.curr_sku.product_sku_id);
                    $(options.titleChange).text(this.curr_sku.title);
                }
                else
                {
                    this.sku_find = false;
                    console.log('SKU not find!');
                }
            },
            getAttrValue : function(attrList){
                var attr = {};
                var attrValue = new Array();
                for (var i = 0; i < attrList.length; i++) 
                {
                    var listPlace = attrList.eq(i);
                    var attr_name  = listPlace.prev(options.btnName).attr(options.dataKey);
                    var attr_value = listPlace.find('.'+options.activeClass).attr(options.dataValue);
                    if(attr_value != undefined) //至少选中一个
                    {
                        attr = {'attr_name':attr_name, 'attr_value': attr_value};
                        attrValue.push(attr);
                    }
                    
                    //仓库
                    if(attr_name == options.btnNameWhouse)
                    {
                        var v = listPlace.find('.'+options.activeClass);
                        var attr_value_id  = v.attr(options.dataId);
                        var attr_value_val = v.attr(options.dataValue);
                        $(options.inputStorageid).val(attr_value_id);
                        $(options.inputWhouse).val(attr_value_val);
                    }
                }
                this.selected = attrValue;
            },
            forbidSelect : function(btn, skus,btn_name){
                var btn_value = btn.attr(options.dataValue);
                //循环剩余的sku，看有没有这个按钮
                var flag = false;
                for (var k in skus) 
                {
                    if(skus[k].isDel == 0)
                    {
                        var whouse2 = skus[k].whouse;
                        var maps2   = skus[k].data;
                        if (btn_name == options.btnNameWhouse)
                        {
                            for(var w2 in whouse2)
                            {
                                if(w2 == btn_value)
                                {
                                    flag = true;
                                }
                            }
                        }
                        else
                        {
                            for(var m2 in maps2)
                            {
                                if(m2 == btn_name && maps2[m2] == btn_value)
                                {
                                    flag = true;
                                }
                            }
                        }                
                    }
                }
                if(!flag)
                {
                    btn.addClass(options.forbidClass).removeClass(options.activeClass);
                }
                else
                {
                    if(btn.hasClass(options.forbidClass))
                    {
                        btn.removeClass(options.forbidClass);
                    }
                }
            }
        }
        this.filter.closeAttr();
        this.filter.events();
        // this.filter.imgSMove();
    }
};
filterAttr.init({
});
})