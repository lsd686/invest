var http = require('http');


var fs = require('fs');
var qs = require('querystring');

var mysql = require('mysql');
var connection = mysql.createConnection({
	host: 'localhost',
	user: 'root',
	password: '',
	database: 'iims',
	port: '3306',
});
connection.connect();

var postData = "";
//*******************************************************************
var app = http.createServer(function(req, res){
	if(req.method === 'GET'){
		switch(req.url){
			case '/index.html':
			fs.readFile('index.html',function(err, data){
				if(err) console.log(err);
				res.writeHeader(200,{'content-type':'text/html'});
				res.end(data.toString());
			});
			break;
			
			case '/addproj.html':
			fs.readFile("addproj.html",function(err,data){
				if(err) console.log(err);
				res.writeHeader(200,{'content-type':'text/html'});				
				res.end(data.toString());
			});
			break;
			
			case '/trans.html':
			fs.readFile("trans.html",function(err,data){
				if(err) console.log(err);
				res.writeHeader(200,{'content-type':'text/html'});
				res.end(data.toString());
			});
			break;
			
			case '/disp.html':
			fs.readFile("disp.html",function(err,data){
				if(err) console.log(err);
				res.writeHeader(200,{'content-type':'text/html'});
				res.end(data.toString());
			});
			break;
			
			case '/display.html':
			var selectsql="select * from trans where projId=01";
			connection.query(selectsql,function(err2,result,fields){
			    if(err2){
				    console.log("err data:"+err2);
				}
				if(result.length > 0){
				    var firstresult="";
					var strHTML="<html><head><title>trans display</title></head><body><fieldset>";
					    strHTML+="<table border='1' borderColor='#009900'>";
						strHTML+="<tr><td>projId</td>";
						strHTML+="<td>price</td>";
						strHTML+="<td>time</td></tr>";
					for(var i=0,len=result.length;i<len;i++){
					    firstresult=result[i];
						strHTML+="<tr>";
						strHTML+="<td>"+firstresult["projId"]+"</td>";
                        strHTML+="<td>"+firstresult["price"]+"</td>";
						strHTML+="<td>"+firstresult["time"].getMonth()+"</td>";
						strHTML+="</tr>";
					}
					strHTML+="</table></fieldset></body></html>";
					res.writeHeader(200,{"Content-Type":"text/html"});
					res.end(strHTML.toString());
				}
			});
			break;
			
			
			
			
		}
	}
	else if(req.method === 'POST'){
		switch(req.url){
			case '/addproj.js':
			postData = "";
			req.on('data',function(chunck){
				postData += chunck;
			});
			
			req.on('end', function(){
			var product = qs.parse(postData);
			console.log(product.projName);
			console.log(product.projNo);
			console.log(product.note);
			
			var insertSQL = "insert into proj(projName,projNo,note) value('"+product.projName+"','"+product.projNo+"','"+product.note+"')";
			connection.query(insertSQL, function(err, res){
				if(err) console.log(error);
				console.log("insert return===>");
				console.log(res);
			});
			res.end(postData);
			});

			break;
			case '/trans.js':
			postData="";
			req.on('data',function(chunck){
				postData+=chunck;
			});
			req.on('end',function(){
				var product2=qs.parse(postData);
				console.log(product2.projId);
				console.log(product2.price);
				console.log(product2.time);
			var insertSQL2="insert into trans(projId,price,time) value('"+product2.projId+"','"+product2.price+"','"+product2.time+"')"
			connection.query(insertSQL2, function(err,res){
				if(err) console.log(err);
				console.log("insert return===>");
				console.log(res);
			});
			res.end(postData);
			});
			break;
			
			case '/disp.js':
			postData="";
			var selectsql="";
			req.on('data',function(chunck){
			    postData+=chunck;
			});
			req.on('end',function(){
			    var product=qs.parse(postData);
				console.log(product.projId);
				
				selectsql="select * from trans where projId='"+product.projId+"'";
				connection.query(selectsql,function(err2,result,fields){
			    if(err2){
				    console.log("err data:"+err2);
				}
				if(result.length > 0){
				    var firstresult="";
					var strHTML="<html><head><meta http-equiv='Content-Type' content='text/html';charset='utf-8'/><title>test</title>";
					    strHTML+="<script language='javascript' src='wz_jsgraphics.js'></script>";
						strHTML+="<script language='javascript' src='line.js'></script></head><body><p>折线图</p>";
						strHTML+="<div id='LineDiv' style='position:relative;height:200px;width:300px;'></div>";
						strHTML+="<script language='javascript'>";
						strHTML+="var y=new Array();";
						strHTML+="var x=new Array();";
					for(var i=0,len=result.length;i<len;i++){
					    firstresult=result[i];
						strHTML+="y["+i+"]="+firstresult["price"]+";";
                        strHTML+="x["+i+"]="+firstresult["time"].getMonth()+";";
					}
					strHTML+="var myline=new Line(LineDiv);";
					strHTML+="myline.drawXYLine(y,x);";
					strHTML+="</script></body></html>";
					res.writeHeader(200,{"Content-Type":"text/html"});
					res.end(strHTML.toString());
					console.log("finished");
				}
				fs.readFile('wz_jsgraphics.js',function(err, data){
				if(err) console.log(err);
				res.writeHeader(200,{'content-type':'text/html'});
				res.end(data.toString());
			   });
			    fs.readFile('line.js',function(err, data){
				if(err) console.log(err);
				res.writeHeader(200,{'content-type':'text/html'});
				res.send("wz_jsgraphics.js");
				res.send("line.js");
				res.end(data.toString());
			    });
			
			
		    });
		    
	        });
	        break;
		}
    }		
});

console.log('the server starts at port 3000');
app.listen(3000);