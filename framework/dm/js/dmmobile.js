function setMobileNav(){
    var authlevel = Number($("#authlevel").data('authlevel'));
    var mnav = [];
    mnav.push('<div class="row">');
    setNav(mnav, '/dm', '系统首页');
    setNav(mnav, '/dm/index/window', '快速窗口');
    if(authlevel >= 2){
        setNav(mnav, '/dm/datacenter/index', '数据概览');
        setNav(mnav, '/dm/allocation/grant', '设备发放');
        setNav(mnav, '/dm/allocation/storage', '设备回收');
        setNav(mnav, '/dm/allocation/holders', '领用记录');
        setNav(mnav, '/dm/allocation/warehouse', '库存设备');
        setNav(mnav, '/dm/allocation/history', '历史记录');
        setNav(mnav, '/dm/device/add_device', '添加设备');
        setNav(mnav, '/dm/device/index', '查看设备');
        setNav(mnav, '/dm/device/content', '内容设置');
        setNav(mnav, '/dm/device/component', '配件设置');
        setNav(mnav, '/dm/personnels/addpersonnel', '添加人员');
        setNav(mnav, '/dm/personnels/index', '查看人员');
        setNav(mnav, '/dm/personnels/dept', '部门设置');
    }
    mnav.push('</div>');
    $(".page-body").prepend(mnav.join(""));
}

function setNav(obj, hrefs, text){
     var nl = '<div class="col-xs-3"><a class="btn btn-link" href="';
     var nm = '">';
     var nr = '</a></div>';
     var fu = nl + hrefs + nm + text + nr;
     obj.push(fu);
}