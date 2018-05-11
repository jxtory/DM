        //-----------------------------------伟大的分割线------------------------------------------

        //S部门设置
        //添加一级部门
        function dept1submit(){
            // var url = "{:url('dm/personnels/box1')}";
            var url = "box1.html";
            var v = $("#dept1box").val();

            $.post(
                url,
                {
                    type: 'adddept',
                    content: v
                }, function(data, textStatus, xhr) {
                /*optional stuff to do after success */
                if(data == "1"){
                    // bootbox.alert("添加成功");
                    $(".widget-caption span").html("&nbsp;添加成功");
                    $(".widget-caption span").css("color", "#9fff00");
                    setTimeout(function(){
                        window.location.href = "?act=level1";
                        // window.location.reload();
                    },1000); 
                } else if (data == "2"){
                    bootbox.alert("已存在该部门");
                    $("#dept1box").val("");
                } else {
                    bootbox.alert("添加失败");
                }

            });
        }

        //添加二级部门
        function dept2submit(){
            // var url = "{:url('dm/personnels/box1')}";
            var url = "box2.html";
            var v = $("#dept2box").val();

            $.post(
                url,
                {
                    type: 'adddept',
                    content: v
                }, function(data, textStatus, xhr) {
                /*optional stuff to do after success */
                if(data == "1"){
                    // bootbox.alert("添加成功");
                    $(".widget-caption span").html("&nbsp;添加成功");
                    $(".widget-caption span").css("color", "#9fff00");
                    setTimeout(function(){
                        window.location.href = "?act=level2";
                    },1000); 
                } else if (data == "2"){
                    bootbox.alert("已存在该部门");
                    $("#dept1box").val("");
                } else {
                    bootbox.alert("添加失败");
                }

            });
        }
        //E部门设置

        //-----------------------------------伟大的分割线------------------------------------------

        //S 编辑部门
        $("#dept1 .btn-group li a").on('click', function(){
            var looklevel = $(this).data('level');
            var lookdept = $(this).data('dept');
            if($(this).html() == "编辑名称"){
                $.post(
                    "deptedit.html",
                    {
                        action: "editdept",
                        level: looklevel,
                        dept: lookdept
                    },
                    function(data){
                        document.write(data);
                    }

                );

            }

            if($(this).html() == "编辑描述"){
                $.post(
                    "deptedit.html",
                    {
                        action: "editdeptcomment",
                        level: looklevel,
                        dept: lookdept
                    },
                    function(data){
                        document.write(data);
                    }

                );

            }

            if($(this).html() == "删除"){
                bootbox.confirm("确实要删除吗？操作不可逆！", function(result){
                    if(result){
                        $.post(
                            "deptedit.html",
                            {
                                action: "delete",
                                level: looklevel,
                                dept: lookdept
                            },
                            function(data){
                                if(data == "1"){
                                    // bootbox.alert("已删除");
                                    $(".widget-caption span").html("&nbsp;删除成功");
                                    $(".widget-caption span").css("color", "#9fff00");
                                    setTimeout(function(){
                                        if(looklevel == "2"){
                                            window.location.href = "?act=level2";                                            
                                        } else {
                                            window.location.href = "?act=level1";                                            

                                        }
                                    },2000); 
                                } else {
                                    bootbox.alert("删除失败");
                                }
                            }
                        );
                        
                    }
                });

            }
            
       });

        $("#dept2 .btn-group li a").on('click', function(){
            var looklevel = $(this).data('level');
            var lookdept = $(this).data('dept');
            if($(this).html() == "编辑名称"){
                $.post(
                    "deptedit.html",
                    {
                        action: "editdept",
                        level: looklevel,
                        dept: lookdept
                    },
                    function(data){
                        document.write(data);
                    }

                );

            }

            if($(this).html() == "编辑描述"){
                $.post(
                    "deptedit.html",
                    {
                        action: "editdeptcomment",
                        level: looklevel,
                        dept: lookdept
                    },
                    function(data){
                        document.write(data);
                    }

                );

            }

            if($(this).html() == "删除"){
                bootbox.confirm("确实要删除吗？操作不可逆！", function(result){
                    if(result){
                        $.post(
                            "deptedit.html",
                            {
                                action: "delete",
                                level: looklevel,
                                dept: lookdept
                            },
                            function(data){
                                if(data == "1"){
                                    // bootbox.alert("已删除");
                                    $(".widget-caption span").html("&nbsp;删除成功");
                                    $(".widget-caption span").css("color", "#9fff00");
                                    setTimeout(function(){
                                        if(looklevel == "2"){
                                            window.location.href = "?act=level2";                                            
                                        } else {
                                            window.location.href = "?act=level1";                                            

                                        }
                                    },2000); 
                                } else {
                                    bootbox.alert("删除失败");
                                }
                            }
                        );
                        
                    }
                });

            }
            
       });

        //S 编辑部门
        function editnamesubmit(){
            // var url = "{:url('dm/personnels/box1')}";
            var url = "deptedit.html";
            var v = $("#editbox").val();
            var looklevel = $("#deptedit").data('level');
            var lookname = $("#deptedit").data('name');
            var lookaction = $("#deptedit").data('action');

            $.post(
                url, 
                {
                    action: lookaction,
                    level: looklevel,
                    newname: v,
                    oldname: lookname
                }, function(data, textStatus, xhr) {
                    /*optional stuff to do after success */
                    if(data == "1"){
                        $(".widget-caption span").html("&nbsp;修改成功，即将跳转");
                        $(".widget-caption span").css("color", "#9fff00");
                        //setinterval
                        setTimeout(function(){
                            if(looklevel == "2"){
                                window.location.href = "dept.html?act=level2";                                            
                            } else {
                                window.location.href = "dept.html?act=level1";                                            

                            }
                        },2000); 
                    } else if (data == "0"){
                        bootbox.alert("无任何改变");
                        $("#editbox").val("");
                    } else {
                        bootbox.alert("修改失败");
                }

            });
            
        }

        //*------

        function editcommentsubmit(){
            // var url = "{:url('dm/personnels/box1')}";
            var url = "deptedit.html";
            var v = $("#editcommentbox").val();
            var looklevel = $("#commentedit").data('level');
            var lookname = $("#commentedit").data('name');
            var lookaction = $("#commentedit").data('action');

            $.post(
                url, 
                {
                    action: lookaction,
                    level: looklevel,
                    newcomment: v,
                    deptname: lookname
                }, function(data, textStatus, xhr) {
                    /*optional stuff to do after success */
                    if(data == "1"){
                        $(".widget-caption span").html("&nbsp;修改成功，即将跳转");
                        $(".widget-caption span").css("color", "#9fff00");
                        setTimeout(function(){
                            if(looklevel == "2"){
                                window.location.href = "dept.html?act=level2";                                            
                            } else {
                                window.location.href = "dept.html?act=level1";                                            

                            }
                        },2000); 
                    } else if (data == "0"){
                        bootbox.alert("无任何改变");
                        $("#editbox").val("");
                    } else {
                        bootbox.alert("添加失败");
                }

            });
            
        }
        //E 结束编辑部门


        //-----------------------------------伟大的分割线------------------------------------------

        // S personnel for add
        //添加人员
        function personnelsubmit(){
            var datas = {};
            datas.types = "addPersonnel";
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
                'box3.html',
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

        //重置人员添加
        $("#personnel_submit a:eq(1)").on("click",function(){
            window.location.reload();
        });


        // E personnel for add

        // S personnel for edit
        //获得编辑人员页面
        $("#lookpersonnels tbody tr").dblclick(function(){
            var uidv = $(this).children('td:first').text();
            $.post(
                'editpersonnel.html',
                {
                    type: 'editPersonnel',
                    uid: uidv
                },
                function(data){
                    document.write(data);
                }
            );
        });

        //获得编辑人员页面
        $("#lookpersonnels tbody tr").find('td:first').mousedown(function(){
            var uidv = $(this).text();
            $.post(
                'editpersonnel.html',
                {
                    type: 'editPersonnel',
                    uid: uidv
                },
                function(data){
                    document.write(data);
                }
            );
        });

        //修改人员
        function editpersonnelsubmit(){
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

        // E personnel for edit

        //-----------------------------------伟大的分割线------------------------------------------
        //S内容设置
        // S类型设置
        function dtsubmit(){
            var url = "handle.html";
            var v = $("#dtbox").val();

            $.post(
                url,
                {
                    type: 'add_devicetype',
                    content: v
                }, function(data, textStatus, xhr) {
                if(data == "1"){
                    $(".widget-caption span").html("&nbsp;添加成功");
                    $(".widget-caption span").css("color", "#9fff00");
                    setTimeout(function(){
                        window.location.href = "?act=dt";
                    },1000); 
                } else if (data == "2"){
                    bootbox.alert("该类型已存在");
                    $("#dtbox").val("");
                } else {
                    bootbox.alert("添加失败");
                }

            });
        }

        // S品牌设置
        function bdsubmit(){
            var url = "handle.html";
            var v = $("#brandbox").val();

            $.post(
                url,
                {
                    type: 'add_brand',
                    content: v
                }, function(data, textStatus, xhr) {
                if(data == "1"){
                    $(".widget-caption span").html("&nbsp;添加成功");
                    $(".widget-caption span").css("color", "#9fff00");
                    setTimeout(function(){
                        window.location.href = "?act=bd";
                    },1000); 
                } else if (data == "2"){
                    bootbox.alert("该品牌已存在");
                    $("#brandbox").val("");
                } else {
                    bootbox.alert("添加失败");
                }

            });
        }

        // S型号设置
        function mlsubmit(){
            var url = "handle.html";
            var v = $("#modelbox").val();

            $.post(
                url,
                {
                    type: 'add_model',
                    content: v
                }, function(data, textStatus, xhr) {
                if(data == "1"){
                    $(".widget-caption span").html("&nbsp;添加成功");
                    $(".widget-caption span").css("color", "#9fff00");
                    setTimeout(function(){
                        window.location.href = "?act=ml";
                    },1000); 
                } else if (data == "2"){
                    bootbox.alert("该型号已存在");
                    $("#modelbox").val("");
                } else {
                    bootbox.alert("添加失败");
                }

            });
        }

        // S配件设置
        function componentsubmit(){
            var url = "handle.html";
            var v = $("#componentbox").val();

            $.post(
                url,
                {
                    type: 'add_component',
                    content: v
                }, function(data, textStatus, xhr) {
                if(data == "1"){
                    $(".widget-caption span").html("&nbsp;添加成功");
                    $(".widget-caption span").css("color", "#9fff00");
                    setTimeout(function(){
                        window.location.reload();
                    },1000); 
                } else if (data == "2"){
                    bootbox.alert("该配件已存在");
                    $("#componentbox").val("");
                } else {
                    bootbox.alert("添加失败");
                }

            });
        }

        // S类型编辑
        $("#devicetype .btn-group li a").on('click', function(){
            var looktitle = $(this).data('title');
            if($(this).html() == "编辑名称"){
                $.post(
                    "handle.html",
                    {
                        type: "edit_devicetype",
                        action: "editdt",
                        title: looktitle
                    },
                    function(data){
                        document.write(data);
                    }

                );

            }

            if($(this).html() == "删除"){
                bootbox.confirm("确实要删除吗？操作不可逆！", function(result){
                    if(result){
                        $.post(
                            "handle.html",
                            {
                                type: 'edit_devicetype',
                                action: "delete",
                                title: looktitle
                            },
                            function(data){
                                if(data == "1"){
                                    $(".widget-caption span").html("&nbsp;删除成功");
                                    $(".widget-caption span").css("color", "#9fff00");
                                    setTimeout(function(){
                                        window.location.href = "?act=dt";                                            
                                    },2000); 
                                } else {
                                    bootbox.alert("删除失败");
                                }
                            }
                        );
                        
                    }
                });

            }
            
       });

        // S品牌编辑
        $("#brand .btn-group li a").on('click', function(){
            var looktitle = $(this).data('title');
            if($(this).html() == "编辑名称"){
                $.post(
                    "handle.html",
                    {
                        type: "edit_brand",
                        action: "editbd",
                        title: looktitle
                    },
                    function(data){
                        document.write(data);
                    }

                );

            }

            if($(this).html() == "删除"){
                bootbox.confirm("确实要删除吗？操作不可逆！", function(result){
                    if(result){
                        $.post(
                            "handle.html",
                            {
                                type: 'edit_brand',
                                action: "delete",
                                title: looktitle
                            },
                            function(data){
                                if(data == "1"){
                                    $(".widget-caption span").html("&nbsp;删除成功");
                                    $(".widget-caption span").css("color", "#9fff00");
                                    setTimeout(function(){
                                        window.location.href = "?act=bd";                                            
                                    },2000); 
                                } else {
                                    bootbox.alert("删除失败");
                                }
                            }
                        );
                        
                    }
                });

            }
            
       });

        // S型号编辑
        $("#model .btn-group li a").on('click', function(){
            var looktitle = $(this).data('title');
            if($(this).html() == "编辑名称"){
                $.post(
                    "handle.html",
                    {
                        type: "edit_model",
                        action: "editml",
                        title: looktitle
                    },
                    function(data){
                        document.write(data);
                    }

                );

            }

            if($(this).html() == "删除"){
                bootbox.confirm("确实要删除吗？操作不可逆！", function(result){
                    if(result){
                        $.post(
                            "handle.html",
                            {
                                type: 'edit_model',
                                action: "delete",
                                title: looktitle
                            },
                            function(data){
                                if(data == "1"){
                                    $(".widget-caption span").html("&nbsp;删除成功");
                                    $(".widget-caption span").css("color", "#9fff00");
                                    setTimeout(function(){
                                        window.location.href = "?act=ml";                                            
                                    },2000); 
                                } else {
                                    bootbox.alert("删除失败");
                                }
                            }
                        );
                        
                    }
                });

            }
            
       });

        // S配件编辑
        $("#componentboxs .btn-group li a").on('click', function(){
            var looktitle = $(this).data('title');
            if($(this).html() == "编辑名称"){
                $.post(
                    "handle.html",
                    {
                        type: "edit_component",
                        action: "editcomponent",
                        title: looktitle
                    },
                    function(data){
                        document.write(data);
                    }

                );

            }

            if($(this).html() == "删除"){
                bootbox.confirm("确实要删除吗？操作不可逆！", function(result){
                    if(result){
                        $.post(
                            "handle.html",
                            {
                                type: 'edit_component',
                                action: "delete",
                                title: looktitle
                            },
                            function(data){
                                if(data == "1"){
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

            }
            
       });

        //编辑实例
        function editcontentnamesubmit(){
            var url = "handle.html";
            var v = $("#editbox").val();
            var lookwho = $("#contentedit").data('who');
            var lookname = $("#contentedit").data('name');

            $.post(
                url, 
                {
                    type: 'edit_content',
                    who: lookwho,
                    newname: v,
                    oldname: lookname
                }, function(data, textStatus, xhr) {
                    /*optional stuff to do after success */
                    if(data == "1"){
                        $(".widget-caption span").html("&nbsp;修改成功，即将跳转");
                        $(".widget-caption span").css("color", "#9fff00");
                        //setinterval
                        setTimeout(function(){
                            if(lookwho == "dt"){
                                window.location.href = "content.html?act=dt";
                            } else if(lookwho == "bd"){
                                window.location.href = "content.html?act=bd";
                            } else if(lookwho == "ml"){
                                window.location.href = "content.html?act=ml";
                            } else if(lookwho == "component"){
                                window.location.reload();
                                // window.location.href = "component.html";
                            }
                        },2000); 
                    } else if (data == "0"){
                        bootbox.alert("无任何改变");
                        $("#editbox").val("");
                    } else {
                        bootbox.alert("修改失败");
                }

            });
            
        }

        //E内容设置

        //-----------------------------------伟大的分割线------------------------------------------
        //S设备添加
        //设备添加
        function devicedatasubmit(){
            var datas = {};
            datas.types = "addDevice";
            datas.an = $("#ds_an").val();
            datas.devicetype = $("#ds_type").val();
            datas.brand = $("#ds_brand").val();
            datas.model = $("#ds_model").val();
            datas.sn = $("#ds_sn").val();
            datas.comment = $("#ds_comment").val();
            $.post(
                'devicehandle.html',
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

        //重置添加设备
        $("#devicedata_submit a:eq(1)").on("click",function(){
            window.location.reload();
        });

        //获得编辑设备页面
        $("#lookdevices tbody tr").dblclick(function(){
            var didv = $(this).children('td:first').text();
            $.post(
                'editDevice.html',
                {
                    types: 'editDevice',
                    did: didv
                },
                function(data){
                    document.write(data);
                }
            );
        });

        //获得编辑设备页面
        $("#lookdevices tbody tr").find("td:first").mousedown(function(){
            var didv = $(this).text();
            $.post(
                'editDevice.html',
                {
                    types: 'editDevice',
                    did: didv
                },
                function(data){
                    document.write(data);
                }
            );
        });

        //修改设备
        function editdevicedatasubmit(){
            var datas = {};
            datas.types = "editDevice";
            datas.did = $("#did").data('did');
            datas.an = $("#ds_an").val();
            datas.devicetype = $("#ds_type").val();
            datas.brand = $("#ds_brand").val();
            datas.model = $("#ds_model").val();
            datas.sn = $("#ds_sn").val();
            datas.comment = $("#ds_comment").val();
            $.post(
                'devicehandle.html',
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
        }

        //放弃设备修改
        $("#editdevicedata_submit a:eq(1)").on("click",function(){
            window.location.reload();
        });

        //删除设备
        $("#editdevicedata_submit a:eq(2)").on("click",function(){
            bootbox.setDefaults("locale", "zh_CN");
            var lookdevice = $(this).data('did');
            bootbox.confirm("确实要删除吗？操作不可逆！", function(result){
                if(result){
                    $.post(
                        "devicehandle.html",
                        {
                            types: "deleteDevice",
                            did: lookdevice
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


        //E设备添加

        //-----------------------------------伟大的分割线------------------------------------------
        //-----------------------------------伟大的分割线------------------------------------------
        //-----------------------------------伟大的分割线------------------------------------------

                // 清空各类数据
        // 清空部门名称数据
        //清空设备型号数据
        $("#tcall").on('click', function () {
            // bootbox.defaults.locale = "zh_CN";
            bootbox.confirm("真的要清空吗?", function (result) {
                if (result) {
                    $.post(
                        "../sys/god.html",
                        {type: 'all'},
                        function(data){
                            bootbox.alert("已完成");
                            setTimeout(function(){
                                window.location.reload();
                            },2000); 
                        }
                    );
                }
            });
        });

        $("#tcdept1").on('click', function () {
            // bootbox.defaults.locale = "zh_CN";
            bootbox.confirm("真的要清空吗?", function (result) {
                if (result) {
                    $.post(
                        "../personnels/tcd.html",
                        {level: 1},
                        function(data){
                            bootbox.alert("已完成");
                            setTimeout(function(){
                                window.location.reload();
                            },2000); 

                        }
                    );
                }
            });
        });

        $("#tcdept2").on('click', function () {
            // bootbox.defaults.locale = "zh_CN";
            bootbox.confirm("真的要清空吗?", function (result) {
                if (result) {
                    $.post(
                        "../personnels/tcd.html",
                        {level: 2},
                        function(data){
                            bootbox.alert("已完成");
                            setTimeout(function(){
                                window.location.reload();
                            },2000); 
                        }
                    );
                }
            });
        });

        //清空人员数据
        $("#tcpersonnels").on('click', function () {
            // bootbox.defaults.locale = "zh_CN";
            bootbox.confirm("真的要清空吗?", function (result) {
                if (result) {
                    $.post(
                        "../sys/tc.html",
                        {type: 'personnels'},
                        function(data){
                            bootbox.alert("已完成");
                            setTimeout(function(){
                                window.location.reload();
                            },2000); 
                        }
                    );
                }
            });
        });

        //清空设备类型数据
        $("#tcdevicetype").on('click', function () {
            // bootbox.defaults.locale = "zh_CN";
            bootbox.confirm("真的要清空吗?", function (result) {
                if (result) {
                    $.post(
                        "../sys/tc.html",
                        {type: 'devicetype'},
                        function(data){
                            bootbox.alert("已完成");
                            setTimeout(function(){
                                window.location.reload();
                            },2000); 
                        }
                    );
                }
            });
        });

        //清空设备品牌数据
        $("#tcbrand").on('click', function () {
            // bootbox.defaults.locale = "zh_CN";
            bootbox.confirm("真的要清空吗?", function (result) {
                if (result) {
                    $.post(
                        "../sys/tc.html",
                        {type: 'brand'},
                        function(data){
                            bootbox.alert("已完成");
                            setTimeout(function(){
                                window.location.reload();
                            },2000); 
                        }
                    );
                }
            });
        });

        //清空设备型号数据
        $("#tcmodel").on('click', function () {
            // bootbox.defaults.locale = "zh_CN";
            bootbox.confirm("真的要清空吗?", function (result) {
                if (result) {
                    $.post(
                        "../sys/tc.html",
                        {type: 'model'},
                        function(data){
                            bootbox.alert("已完成");
                            setTimeout(function(){
                                window.location.reload();
                            },2000); 
                        }
                    );
                }
            });
        });

        //清空设备数据
        $("#tcdevices").on('click', function () {
            // bootbox.defaults.locale = "zh_CN";
            bootbox.confirm("真的要清空吗?", function (result) {
                if (result) {
                    $.post(
                        "../sys/tc.html",
                        {type: 'devices'},
                        function(data){
                            bootbox.alert("已完成");
                            setTimeout(function(){
                                window.location.reload();
                            },2000); 
                        }
                    );
                }
            });
        });

        //清空领用数据
        $("#tcholders").on('click', function () {
            // bootbox.defaults.locale = "zh_CN";
            bootbox.confirm("真的要清空吗?", function (result) {
                if (result) {
                    $.post(
                        "../sys/tc.html",
                        {type: 'holders'},
                        function(data){
                            bootbox.alert("已完成");
                            setTimeout(function(){
                                window.location.reload();
                            },2000); 
                        }
                    );
                }
            });
        });

        //清空配件数据
        $("#tccomponents").on('click', function () {
            // bootbox.defaults.locale = "zh_CN";
            bootbox.confirm("真的要清空吗?", function (result) {
                if (result) {
                    $.post(
                        "../sys/tc.html",
                        {type: 'components'},
                        function(data){
                            bootbox.alert("已完成");
                            setTimeout(function(){
                                window.location.reload();
                            },2000); 
                        }
                    );
                }
            });
        });

        //清空历史数据
        $("#tchistory").on('click', function () {
            // bootbox.defaults.locale = "zh_CN";
            bootbox.confirm("真的要清空吗?", function (result) {
                if (result) {
                    $.post(
                        "../sys/tc.html",
                        {type: 'history'},
                        function(data){
                            bootbox.alert("已完成");
                            setTimeout(function(){
                                window.location.reload();
                            },2000); 
                        }
                    );
                }
            });
        });

        //清空MAC数据
        $("#tcmacaddress").on('click', function () {
            // bootbox.defaults.locale = "zh_CN";
            bootbox.confirm("真的要清空吗?", function (result) {
                if (result) {
                    $.post(
                        "../sys/tc.html",
                        {type: 'macaddress'},
                        function(data){
                            bootbox.alert("已完成");
                            setTimeout(function(){
                                window.location.reload();
                            },2000); 
                        }
                    );
                }
            });
        });

        //清空品质数据
        $("#tcquality").on('click', function () {
            // bootbox.defaults.locale = "zh_CN";
            bootbox.confirm("真的要清空吗?", function (result) {
                if (result) {
                    $.post(
                        "../sys/tc.html",
                        {type: 'quality'},
                        function(data){
                            bootbox.alert("已完成");
                            setTimeout(function(){
                                window.location.reload();
                            },2000); 
                        }
                    );
                }
            });
        });

        //清空品质数据
        $("#tcrepair").on('click', function () {
            // bootbox.defaults.locale = "zh_CN";
            bootbox.confirm("真的要清空吗?", function (result) {
                if (result) {
                    $.post(
                        "../sys/tc.html",
                        {type: 'repair'},
                        function(data){
                            bootbox.alert("已完成");
                            setTimeout(function(){
                                window.location.reload();
                            },2000); 
                        }
                    );
                }
            });
        });

        //-----------------------------------伟大的分割线------------------------------------------