	// JavaScript Document
	
	/*var dlgRslt,lastTimeDialogClosed = 0;

	function dialog(msg) {
		var defaultValue,
			lenIsThree,
			type;

		while (lastTimeDialogClosed && new Date() - lastTimeDialogClosed < 3001) {
			// timer
		}

		lenIsThree = 3 === arguments.length;
		type = lenIsThree ? arguments[2] : (arguments[1] || alert);
		defaultValue = lenIsThree && type === prompt ? arguments[1] : '';

		// store result of confirm() or prompt()
		dlgRslt = type(msg, defaultValue);
		lastTimeDialogClosed = new Date();
	}
	*/		
	
	function roundFix(number, precision)
	{
		var multi = Math.pow(10, precision);
		return Math.round( (number * multi).toFixed(precision + 1) ) / multi;
	}
	
	function isNumberKey(evt){
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57)){
			return false;
		}else{
			return true;
		}
	}


	function isOverLimit(evt,ob,val){
		var charCode = (evt.which) ? evt.which : event.keyCode
		if(charCode == 8){
			return true;
		}else{
			if(ob.length >= val){
				return false;
			}else{
				return true;
			}
		}
	}
	
	function isPasteOverLimit(ob,val){
		if(ob.value !=''){
			if(ob.value.length >= val){
				alert('Error...!!\nCharacter over than limits :: '+val);
				ob.value='';
			}
		}
	}
	
	function _delConfirm(obj){
		if (obj.checked == true){
			var trueVal = confirm('Anda yakin untuk menghapus data..!!')
			if( trueVal == true ){
				obj.checked = true
			}
			else{
				obj.checked = false 
			}
		}
	}
	
	function dateAddExtention(p_Interval, p_Number){ 
	    var thing = new String(); 
	     
	    //in the spirt of VB we'll make this function non-case sensitive 
	    //and convert the charcters for the coder. 
	    p_Interval = p_Interval.toLowerCase(); 
	     
	    if(isNaN(p_Number)){ 
	     
	        //Only accpets numbers 
	        //throws an error so that the coder can see why he effed up     
	        throw "The second parameter must be a number. \n You passed: " + p_Number; 
	        return false; 
	    } 
	    p_Number = new Number(p_Number); 
	    switch(p_Interval.toLowerCase()){ 
	        case "yyyy": {// year 
	            this.setFullYear(this.getFullYear() + p_Number); 
	            break; 
	        } 
	        case "q": {        // quarter 
	            this.setMonth(this.getMonth() + (p_Number*3)); 
	            break; 
	        } 
	        case "m": {        // month 
	            this.setMonth(this.getMonth() + p_Number); 
	            break; 
	        } 
	        case "y":        // day of year 
	        case "d":        // day 
	        case "w": {        // weekday 
	            this.setDate(this.getDate() + p_Number); 
	            break; 
	        } 
	        case "ww": {    // week of year 
	            this.setDate(this.getDate() + (p_Number*7)); 
	            break; 
	        } 
	        case "h": {        // hour 
	            this.setHours(this.getHours() + p_Number); 
	            break; 
	        } 
	        case "n": {        // minute 
	            this.setMinutes(this.getMinutes() + p_Number); 
	            break; 
	        } 
	        case "s": {        // second 
	            this.setSeconds(this.getSeconds() + p_Number); 
	            break; 
	        } 
	        case "ms": {        // second 
	            this.setMilliseconds(this.getMilliseconds() + p_Number); 
	            break; 
	        } 
	        default: { 
	         
	            //throws an error so that the coder can see why he effed up and 
	            //a list of elegible letters. 
	            throw    "The first parameter must be a string from this list: \n" + 
	                    "yyyy, q, m, y, d, w, ww, h, n, s, or ms. You passed: " + p_Interval; 
	            return false; 
	        } 
	    } 
	    return this; 
	}
	
	function _getTimeFinish(obj){
		var x = obj.id.split('_');
		var tgl = document.getElementById('tanggal');
		var jam = document.getElementById('jamstart_'+x[1]);
		var rst = document.getElementById('rest_'+x[1]);
		var mp = document.getElementById('manpower_'+x[1]);
		var qty = document.getElementById('jumlah_'+x[1]);
		var st = document.getElementById('st_'+x[1]);
		var mode = document.getElementById('mode_'+x[1]);
		if(tgl.value !==''){
			if(jam.value ==''||jam.value =='00:00'||mp.value ==''||qty.value ==''||st.value ==''){
			}else{
				if(jam.value.indexOf(':')=='2'){
					var tglx = tgl.value.split('-');
					var jamx = jam.value.split(':');
					if(mode.value!=='No Check'){
						var mm = ((qty.value * st.value) / mp.value) + parseFloat(rst.value);
					}else{
						var mm = ((qty.value * 0) / mp.value) + parseFloat(rst.value);
					}
					Date.prototype.dateAdd = dateAddExtention;              
					var dToday = new Date(tglx[1]+' '+tglx[0]+', '+tglx[2]+' '+jamx[0]+':'+jamx[1]+':00');   
					dToday = dToday.dateAdd("n", mm);
					//document.getElementById('jamfinish_'+x[1]).value = dToday.toLocaleTimeString()
					var x1 = dToday.toString();
					var x2 = x1.split(' ');
					document.getElementById('jamfinish_'+x[1]).value = x2[4];
				}else{
					alert('Format penulisan salah..!!');
					jam.value ='00:00';
					jam.focus();
				}
			}
		}else{alert('Mohon isikan tanggal planning produksi...!');tgl.focus();}
	}

	
	var DateDiff = {
	
	    inDays: function(d1, d2) {
	        var t2 = d2.getTime();
	        var t1 = d1.getTime();
	
	        return parseInt((t2-t1)/(24*3600*1000));
	    },
	
	    inWeeks: function(d1, d2) {
	        var t2 = d2.getTime();
	        var t1 = d1.getTime();
	
	        return parseInt((t2-t1)/(24*3600*1000*7));
	    },
	
	    inMonths: function(d1, d2) {
	        var d1Y = d1.getFullYear();
	        var d2Y = d2.getFullYear();
	        var d1M = d1.getMonth();
	        var d2M = d2.getMonth();
	        
	        return (d2M+12*d2Y)-(d1M+12*d1Y);
	    },
	
	    inYears: function(d1, d2) {
	        return d2.getFullYear()-d1.getFullYear();
	    }
	}
	
	var xmlHttp
	function showCustomer(str){
		xmlHttp=GetXmlHttpObject()
		if (xmlHttp==null){
			alert ("Browser does not support HTTP Request")
			return
		} 
		var url="getcustomer.asp"
		url=url+"?q="+str
		url=url+"&sid="+Math.random()
		xmlHttp.onreadystatechange=stateChanged 
		xmlHttp.open("GET",url,true)
		xmlHttp.send(null)
	}

	function stateChanged(){ 
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){ 
			document.getElementById("splCompany_").innerHTML=xmlHttp.responseText 
		}
	} 

	function GetXmlHttpObject(){ 
		var objXMLHttp=null
		if (window.XMLHttpRequest){
			objXMLHttp=new XMLHttpRequest()
		}else if (window.ActiveXObject){
			objXMLHttp=new ActiveXObject("Microsoft.XMLHTTP")
		}
		return objXMLHttp
	}
	
	var xmlHttp1
	function showLots(str,loc){
		xmlHttp1=GetXmlHttpObject1()
		if (xmlHttp1==null){
			alert ("Browser does not support HTTP Request")
			return
		} 
		var url="getlot.asp";
		url=url+"?q="+str;
		url=url+"&qq="+loc;
		url=url+"&sid="+Math.random();
		xmlHttp1.onreadystatechange=stateChanged1
		xmlHttp1.open("GET",url,true)
		xmlHttp1.send(null)
	}

	function stateChanged1(){ 
		if (xmlHttp1.readyState==4 || xmlHttp1.readyState=="complete"){ 
			document.getElementById("Lots").innerHTML=xmlHttp1.responseText 
		}
	} 

	function GetXmlHttpObject1(){ 
		var objXMLHttp1=null
		if (window.XMLHttpRequest){
			objXMLHttp1=new XMLHttpRequest()
		}else if (window.ActiveXObject){
			objXMLHttp1=new ActiveXObject("Microsoft.XMLHTTP")
		}
		return objXMLHttp1
	}
	
	//function roundNumber(rnum, rlength) { 
	//	var newnumber = Math.round(rnum * Math.pow(10, rlength)) / Math.pow(10, rlength);
	//	return newnumber;
	//}
	
	