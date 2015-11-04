var http=require("http");
var fs=require("fs");
var qs=require("querystring");
var mysql=require("mysql");

var connection=mysql.createConnection({
    host:"localhost",
	user:"root",
	password:"911911zhg",
	database:"iims",
	port:"3306"
});
connection.connect();

var postData="";

var app=http.createServer(function(req,res){
	if(req.method==="get"){
		switch(req.url){
			case "/disp.html":
			var selectsql="select * from proj";
		connection.query(selectsql,function(err2,result,fields){
			if(err2){
				console.log("Getdata Error:"+err2);
			}
			if(result.length>0){
				var firstresult="";
				var strHTML="";
				strHTML="<html><head><title>disp</title></head><body><fieldset>";
				strHTML+="<legend>proj disp</legend>";
				strHTML+="<table border='1' borderColor='#009900'>";
				strHTML+="<tr><td>projName</td>";
				strHTML+="<td>projNo</td>";
				strHTML+="<td>note</td>";
				strHTML+="</tr>";
				for(var i=0,len=result.length;i<len;i++){
					firstresult=result[i];
					strHTML+="<tr>";
					strHTML+="<td>"+firstresult["projName"]+"</td>";
					strHTML+="<td>"+firstresult["projNo"]+"</td>";
					strHTML+="<td>"+firstresult["note"]="</td>";
					strHTML+="</tr></table>";
				}
				strHTML+="</fieldset></body></html>";
				res.writeHeader(200,{"Content-Type":"text/html"});
				res.end(strHTML.toString());
			}
		    });
			break;
		}
	}
	else if(req.method==="post"){
		switch(req.url){
			case "/addproj.js":
			req.on("data",function(chunck){
				postData+=chunck;
			});
			req.on("end",function(){
				var website1=qs.parse(postData);
				console.log(website1.projName);
				console.log(website1.projNo);
				console.log(website1.note);
				var insertsql1="insert into proj(projName,projNo,note) values('"+website1.projName+"','"+projNo+"','"+note+"')";
				connection.query(insertsql1,function(err0,res0){
					if(err0) console.log(err0);
					console.log("Insert Return==>");
					console.log(res0);
				});
				res.end(postData);
			});
			break;
		}
	}
});
app.listen(7798);
