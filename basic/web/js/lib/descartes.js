(function(){
    //笛卡尔积
    var Cartesian = function(a,b,join){
    //console.log(a,b);
        var ret=[];
        for(var i=0;i<a.length;i++){
            for(var j=0;j<b.length;j++){
                ret.push(ft(a[i],b[j],join));
            }
        }
        return ret;
    }
    var ft = function(a,b,join){
        if(!(a instanceof Array))
        a = [a];
        var ret = Array.call(null,a);
        ret.push(b);
        if(join == true){
           ret = ret.join('');
        }
        return ret;
    }
    //多个一起做笛卡尔积
    multiCartesian = function(data,join){
        var len = data.length;
        if(len == 0)
            return [];
        else if(len == 1)
            return data[0];
        else{
            var r=data[0];
            for(var i=1;i<len;i++){
                r=Cartesian(r,data[i],join);
            }
            return r;
        }
    }
})();