        //以下为处理领用人ID的代码
        $("#ds_pid").focus(function(){
            $("#getHolderInfoDiv").fadeIn();
        });

        $("#ds_pid").blur(function(){
            $("#getHolderInfoDiv").fadeOut();
        });

        $("#ds_pid").bind("input propertychange", function(){
            $("#getHolderInfo tbody").html("");
            $.post(
                    "getInfos.html",
                    {
                        type: "getHolderInfo",
                        content: function(){return $("#ds_pid").val();}
                    },
                    function(data, status){
                        $("#getHolderInfo tbody").html("");
                        if(status == "success" && data != ""){
                            for(v in data){
                                var content = "<tr>";
                                content += "<td>" + data[v]['id'] + "</td>";
                                content += "<td>" + data[v]['personnel'] + "</td>";
                                content += "<td>" + data[v]['sex'] + "</td>";
                                content += "<td>" + data[v]['position'] + "</td>";
                                content += "<td>" + data[v]['dept1'] + "</td>";
                                content += "<td>" + data[v]['dept2'] + "</td>";
                                content += "</tr>";
                                $("#getHolderInfo tbody").html($("#getHolderInfo tbody").html() + content);

                            }
                        } else {

                        }
                    }
                );

        });

        $("#getHolderInfo").on('mousedown', 'tr', function(){
            $("#ds_pid").val($(this).children('td:first').text());
            var e = jQuery.Event("keyup");//模拟一个键盘事件
            e.keyCode =13;//keyCode=13是回车
            $("#ds_pid").trigger(e);                
        });

        //----------------------------伟大的分割线---------------------------
        //以下为处理固资编号的代码
        $("#ds_an").focus(function(){
            $("#getDeviceInfoDiv").fadeIn();
        });

        $("#ds_an").blur(function(){
            $("#getDeviceInfoDiv").fadeOut();
        });

        $("#ds_an").bind("input propertychange", function(){
            $("#getDeviceInfo tbody").html("");
            $.post(
                    "getInfos.html",
                    {
                        type: "getDeviceInfo",
                        content: function(){return $("#ds_an").val();}
                    },
                    function(data, status){
                        $("#getDeviceInfo tbody").html("");
                        if(status == "success" && data != ""){
                            for(v in data){
                                var content = "<tr>";
                                content += "<td>" + data[v]['an'] + "</td>";
                                content += "<td>" + data[v]['type'] + "</td>";
                                content += "<td>" + data[v]['brand'] + "</td>";
                                content += "<td>" + data[v]['model'] + "</td>";
                                content += "</tr>";
                                $("#getDeviceInfo tbody").html($("#getDeviceInfo tbody").html() + content);

                            }
                        } else {

                        }
                    }
                );
        });

        $("#getDeviceInfo").on('mousedown', 'tr', function(){
            $("#ds_an").val($(this).children('td:first').text());
            var e = jQuery.Event("keyup");//模拟一个键盘事件
            e.keyCode =13;//keyCode=13是回车
            $("#ds_an").trigger(e);                
        });

        //----------------------------伟大的分割线---------------------------
        //设备发放
        function grantdatasubmit(){
            $(window).scrollTop($(".page-body").offset().top);
            var datas = {};
            datas.types = "addGrant";
            datas.ds_pid = $("#ds_pid").val();
            datas.ds_an = $("#ds_an").val();
            datas.ds_component = function(){
                var str = "";
                $("input[name='ds_component']:checked").each(function() {
                    str += $(this).val() + ",";
                });;
                return str;
            }; 
            datas.ds_time = $("#ds_time").val();
            $.post(
                'allochandle.html',
                datas,
                function(data){
                    lookresult(data, 1);
                    if(data == "1"){
                        // bootbox.alert("添加成功");
                        $(".widget-caption span").html("&nbsp;添加成功");
                        $(".widget-caption span").css("color", "#9fff00");
                        setTimeout(function(){
                            window.location.reload();
                        },1000); 
                    } else if (data == "2"){
                        bootbox.alert("未知的错误");
                        // $("#personneldata").reset();
                    } else {
                        bootbox.alert("添加失败");
                    }

            });
        //     // $("#personnel_submit a:first").on("click",function(){});            
        }

        //重置设备发放
        $("#grantdata_submit a:eq(1)").on("click",function(){
            window.location.reload();
        });

        //S 获得领用情况修改页面
        $("#holderdevices tbody tr").dblclick(function(){
            var hidv = $(this).children('td:first').text();
            $.post(
                'editholdinfo.html',
                {
                    type: 'editHoldInfo',
                    hid: hidv
                },
                function(data){
                    document.write(data);
                }
            );
        });

        //S 获得领用情况修改页面
        $("#holderdevices tbody tr").find('td:first').mousedown(function(){
            var hidv = $(this).text();
            $.post(
                'editholdinfo.html',
                {
                    type: 'editHoldInfo',
                    hid: hidv
                },
                function(data){
                    document.write(data);
                }
            );
        });

        //修改领用情况
        function editHoldInfoSubmit(){
            var datas = {};
            datas.types = "editPersonnel";
            datas.uid = $("#uid").data('uid');
            datas.personnel = $("#personnel").val();
            datas.phoneticize = $("#phoneticize").val();
            datas.sex = $("#sex").val();
            datas.dept1 = $("#dept1").val();
            datas.dept2 = $("#dept2").val();
            datas.leader = $("#leader").val();
            datas.position = $("#position").val();
            datas.statusdm = $("#statusdm")[0].selectedIndex;
            datas.timedm = $("#timedm").val();
            $.post(
                'box4.html',
                datas,
                function(data){
                    lookresult(data, 1);
                    if(data == "1"){
                        $(".widget-caption span").html("&nbsp;修改成功");
                        $(".widget-caption span").css("color", "#9fff00");
                        setTimeout(function(){
                            window.location.reload();
                        },1000); 
                    } else if (data == "2"){
                        bootbox.alert("未知的错误");
                    } else {
                        bootbox.alert("修改失败");
                        setTimeout(function(){
                            window.location.reload();
                        },1000);
                    }

            });
        //     // $("#personnel_submit a:first").on("click",function(){});            
        }

        //放弃人员修改
        $("#editpersonnel_submit a:eq(1)").on("click",function(){
            window.location.reload();
        });

        //删除人员
        $("#editpersonnel_submit a:eq(2)").on("click",function(){
            bootbox.setDefaults("locale", "zh_CN");
            var lookpersonnel = $(this).data('uid');
            bootbox.confirm("确实要删除吗？操作不可逆！", function(result){
                if(result){
                    $.post(
                        "box4.html",
                        {
                            types: "deletePersonnel",
                            uid: lookpersonnel
                        },
                        function(data){
                            if(data == "1"){
                                // bootbox.alert("已删除");
                                $(".widget-caption span").html("&nbsp;删除成功");
                                $(".widget-caption span").css("color", "#9fff00");
                                setTimeout(function(){
                                    window.location.reload();
                                },2000); 
                            } else {
                                bootbox.alert("删除失败");
                            }
                        }
                    );
                    
                }
            });

        });

        // E 领用情况修改
        //----------------------------伟大的分割线---------------------------
