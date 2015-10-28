// Initialize Analog Interactive Clock
/*
function Clock_dg(prop) {
    var angle = 360/60,
        date = new Date();
        var h = date.getHours();
		//alert(h);
		h = 12;
        if(h > 12) {
            h = h - 12;
        }

        hour = h;
        minute = date.getMinutes(),
		//minute = 45,
		
        second = date.getSeconds(),
		//alert(second);
		//second = 5,
        hourAngle = (360/12) * hour + (360/(12*60)) * minute;

        $('#minute')[0].style[prop] = 'rotate('+angle * minute+'deg)';
        $('#second')[0].style[prop] = 'rotate('+angle * second+'deg)';
        $('#hour')[0].style[prop] = 'rotate('+hourAngle+'deg)';
}
*/
$(function(){
    var props = 'transform WebkitTransform MozTransform OTransform msTransform'.split(' '),
        prop,
        el = document.createElement('div');

    for(var i = 0, l = props.length; i < l; i++) {
        if(typeof el.style[props[i]] !== "undefined") {
            prop = props[i];
            break;
        }
    }
    setInterval(function(){
        Clock_dg(prop)
    },100);
});