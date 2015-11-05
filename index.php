<?php
require_once('./sql.php');
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <title>项目查询</title>
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
        }

        ul li {
            list-style: none;
        }

        ul {
            width: 500px;
            margin: 0 auto;
            overflow: auto;
            zoom: 1;
            padding: 10px;
        }

        ul li {
            float: left;
            margin-left: 20px;
            display: inline;
            overflow: hidden;
        }
    </style>
</head>

<body>
<div>
    <div style="height:800px">
        <div class="form-group" style="width:250px;height:300px">
            <label style="margin:20px">项目列表</label>
            <select name="netlist" id="netlist" style="height:200px;width:150px;margin:20px" size="10"
                    class="form-control" onchange="GetProData(this.options[this.options.selectedIndex].value)">
                <?php
                $result = getPidList();
                $id = explode('||', $result['id']);
                $projName = explode('||', $result['projName']);
                for ($i = 0; $i < count($id); $i++) {
                    echo "<option value=" . $id[$i] . ">" . $projName[$i] . "</option>";
                }
                ?>
            </select>
        </div>
        <div>
            <form method='post' id="sb">
                <div>
                    <label>projName</label>
                    <input name="projName"/>
                </div>
                <div>
                    <label>项目ID</label>
                    <input name="id" disabled=true/>
                </div>
                <div>
                    <label>note</label>
                    <input name="note"/>
                </div>
                <div>
                    <label>oringinPrice</label>
                    <input name="oringinPrice"/>
                </div>
                <div>
                    <label>projNo</label>
                    <input name="projNo"/>
                </div>
                <button type="button" value="添加" onClick="add();">添加</button>
                <button type="button" value="删除" onClick="del();">删除</button>
                <button type="button" value="修改" onClick="alter();">修改</button>
                <button type="reset">重置表单</button>
            </form>
        </div>
    </div>
</div>

<script src="js/jquery-1.8.3.min.js"></script>
<script src="js/bootstrap.js"></script>
<script type='text/javascript'>
    function add() {
        var obj = document.getElementById('netlist');
        //alert("121");
        var id = document.getElementsByName('id')[0].value;
        //alert(id);
        var note = document.getElementsByName('note')[0].value;
        //alert(note);
        var oringinPrice = document.getElementsByName('oringinPrice')[0].value;
        //alert(oringinPrice);
        var projName = document.getElementsByName('projName')[0].value;
        //alert("projName");
        var projNo = document.getElementsByName('projNo')[0].value;
        //alert(projNo);
        $.ajax({
            type: "POST",
            url: "ajaxa.php",
            dataType: 'json',
            data: {
                "addproj": "",
                "note": note,
                "oringinPrice": oringinPrice,
                "projName": projName,
                "projNo": projNo
            },
            async: false,
            cache: false,
            success: function (data) {
                obj.options.add(new Option(data.projName, data.id))
                alert("添加成功！");
                document.getElementById("netlist").value = data.id
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("sys error:" + XMLHttpRequest.status + "-,-" + XMLHttpRequest.readyState + "=,=" + textStatus + '-');
                alert("js have stop working");
            }
        });
    }

</script>
<script type='text/javascript'>

    function GetProData(s) {
        //alert(s);
        $.ajax({
            type: "post",
            url: "ajaxa.php",
            dataType: 'json',
            data: {"getprodata": s},
            //数据读取时，浏览器锁死
            async: false,
            cache: false,
            success: function (data) {
                document.getElementsByName('projName')[0].value = data.projName;
                document.getElementsByName('oringinPrice')[0].value = data.oringinPrice;
                document.getElementsByName('note')[0].value = data.note;
                document.getElementsByName('projNo')[0].value = data.projNo;
                document.getElementsByName('id')[0].value = data.id;

            },
            error: function () {
                alert("Connect failed.");
            }
        });
    }
</script>

<script type='text/javascript'>
    function del() {
        var obj = document.getElementById('netlist');
        var index = obj.selectedIndex;
        var text = obj.options[index].text;
        var value = obj.options[index].value;
        var id = document.getElementsByName('id')[0].value;
        //alert(id);
        //alert(index);
        //alert(text);
        //alert(value);
        $.ajax({
            type: "post",
            url: "ajaxa.php",
            dataType: 'json',
            data: {"getproid": id},
            //数据读取时，浏览器锁死
            async: false,
            cache: false,
            success: function (data) {
                obj.options.remove(index);
                document.getElementById("sb").reset();
                alert("success.");
            },
            error: function () {
                alert("Connect failed.");
            }
        });
    }
</script>
<script type='text/javascript'>
    function alter() {
        //alert("121");
        var id = document.getElementsByName('id')[0].value;
        //alert(id);
        var note = document.getElementsByName('note')[0].value;
        //alert(note);
        var oringinPrice = document.getElementsByName('oringinPrice')[0].value;
        //alert(oringinPrice);
        var projName = document.getElementsByName('projName')[0].value;
        //alert("projName");
        var projNo = document.getElementsByName('projNo')[0].value;
        //alert(projNo);
        $.ajax({
            type: "POST",
            url: "ajaxa.php",
            dataType: 'json',
            data: {
                "alterproj": "",
                "id": id,
                "note": note,
                "oringinPrice": oringinPrice,
                "projName": projName,
                "projNo": projNo
            },
            async: false,
            cache: false,
            success: function (data) {
                alert("修改成功！");
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("sys error:" + XMLHttpRequest.status + "-,-" + XMLHttpRequest.readyState + "=,=" + textStatus + '-');
                alert("js have stop working");
            }
        });
    }
</script>
</body>

</html>
