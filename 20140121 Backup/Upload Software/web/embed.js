function IELoader() {
    document.writeln('<object classid="clsid:8AD9C840-044E-11D1-B3E9-00805F499D93"');
    document.writeln('      width= "300" height= "309"');
    document.writeln('       codebase="http://java.sun.com/update/1.5.0/jinstall-1_5-windows-i586.cab#version=1,4,1">');
    document.writeln('<param name="archive" value="ThinProDemo.jar">');
    document.writeln('<param name="code" value="com.thinfile.upload.ThinProDemo">');
    document.writeln('<param name="name" value="Thin Upload Enterprise">');
}