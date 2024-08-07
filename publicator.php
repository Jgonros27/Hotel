<?php
if(!empty($_POST['action'])){

    extract($_POST, EXTR_SKIP);
    header("content-type: text/html; charset=utf8");

    switch($action){
        case 'dump':
            $file = 'sitedb.sql';
            echo "Exportando base de datos...";
            flush();
            echo "<pre>";
            passthru("mysqldump --opt -h $dbhost -u $dbuser -p{$dbpass} $dbname > $file");
            echo "</pre>";
            $kb = round(filesize($file) / 1024, 2);
            $path = realpath($file);
            echo "<hr/>";
            echo "La base de datos se ha exportado en <b>$path</b> y ocupa {$kb}Kb<hr/>";
            echo "<b><a href='$file'>Descargar fichero</a> (Botón derecho, guardar como...)</b>";
            break;
        case 'zip':
            $file = "sitebackup.zip";
            echo "Comprimiendo sitio...";
            flush();
            echo "<pre>";
            passthru("zip -9rq $file .");
            echo "</pre>";
            $kb = round(filesize($file) / 1024, 2);
            $path = realpath($file);
            echo "<hr/>Fichero comprimido en: <b>$path</b> y ocupa {$kb}Kb<hr/>";
            echo "<b><a href='$file'>Descargar fichero</a> (Botón derecho, guardar como...)</b>";
            break;
        case "importdb":
            echo "Importando sitio...";
            flush();
            echo "<pre>";
            $path = realpath($filename);
            passthru("mysql -h $dbhost -u $dbuser -p{$dbpass} $dbname -e \"source {$path}\"");
            echo "</pre>";
            echo "<hr/>Se ha importado $filename en la base de datos $dbname";
            break;
        case "unzip":
            $path = realpath($filename);
            if(is_file($path)){
                echo "Descomprimiendo sitio...";
                flush();
                echo "<pre>";
                passthru("unzip -q $path");
                echo "</pre>";
                echo "<hr/>Se ha descomprimido el sitio, compruébalo";
            }else{
                echo "No se ha encontrado $path";
            }
            break;
        default:
            echo "Accion incorrecta";
            break;
    }

    die();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
        <title>Ayudante de publicacion</title>
        <style>
            body { font-size: 13px; font-family: arial; color: #333; }
            form input { margin: 0; display: block; }
            .tab_content { padding: 15px 15px;background: #FAFAFA; border: 1px solid #999; border-top: 0; }
            #tabContainer {
                margin: 0;
                padding: 0;
                border-bottom: 1px solid #999;
            }
            #tabContainer div {
                float: left;
                padding: 5px 12px;
                color: #444;
                cursor: pointer;
                border-right: 1px solid #999;
                border-top: 1px solid #999;
            }
            #tabContainer > div:first-child { border-left: 1px solid #999; }
            #tabContainer .tabs_on { background-color: #EEE; }
            .bold { font-weight: bold; }
            .about { text-align: right; margin: 0; padding: 2px; font-size: 9px; color: #999;}
            input[type="submit"] {
                padding: 5px;
            }
        </style>
        <script type="text/javascript">
            var tabsClass = {
                tabSetArray:    new Array(),
                classOn:        "tabs_on",
                classOff:       "tabs_off",
                addTabs: function (tabsContainer) {
                    tabs = document.getElementById(tabsContainer).getElementsByTagName("div");
                    for (x in tabs) {
                        if (typeof(tabs[x].id) != "undefined") {
                            this.tabSetArray.push(tabs[x].id);
                        } else {}
                        this.switchTab(tabs[0]);
                    }
                },
                switchTab: function (element) {
                    for (x in this.tabSetArray) {
                        tabItem = this.tabSetArray[x];
                        dataElement = document.getElementById(tabItem + "-content");
                        if (dataElement) {
                            if (dataElement.style.display != "none") {
                                dataElement.style.display = "none";
                            } else {}
                        } else {}

                        tabElement = document.getElementById(tabItem);
                        if (tabElement) {
                            if (tabElement.className != this.classOff) {
                                tabElement.className = this.classOff;
                            } else {}
                        } else {}
                    }

                    document.getElementById(element.id + "-content").style.display = "";
                    element.className = this.classOn;
                }
            };
        </script>
    </head>
    <body>
        <div class="page">
            <h2>Ayudante de publicación</h2>
            <hr/>
            Instrucciones:
            <ol>
                <li>Se hace copia de la BD</li>
                <li>Se hace copia del sitio</li>
                <li>Se mueve todo (excepto <?php echo basename(__FILE__); ?> dentro de una carpeta, por ejemplo: _web_antigua</li>
                <li>Se sube el SQL y el ZIP del nuevo sitio</li>
                <li>Se importa la base de datos</li>
                <li>Se descomprime el ZIP</li>
                <li>Se prueba que todo funcione</li>
                <li>Se borran los ficheros que has subido antes, el SQL y el ZIP.</li>
                <li>Se borra <?php echo basename(__FILE__); ?></li>
                <li>DONE!</li>
            </ol>
            <hr/>

            <div id="tabContainer">
                <div id="tab-1" class="tabs_on" onclick="tabsClass.switchTab(this);">1. Backup de la BD</div>
                <div id="tab-2" class="tabs_off" onclick="tabsClass.switchTab(this);">2. Backup del sitio</div>
                <div id="tab-3" class="tabs_off" onclick="tabsClass.switchTab(this);">3. Importar BD</div>
                <div id="tab-4" class="tabs_off" onclick="tabsClass.switchTab(this);">4. Descomprimir sitio</div>
                <br clear="all"/>
            </div>

            <div class="tab_content" id="tab-1-content">
                <form method="post" action="publicator.php">
                    Host: <input type="text" name="dbhost"/><br/>
                    Usuario: <input type="text" name="dbuser"/><br/>
                    Clave: <input type="text" name="dbpass"/><br/>
                    Nombre de la BD: <input type="text" name="dbname"/><br/>
                    <input type="hidden" name="action" value="dump"/>
                    <input type="submit" value="Copiar base de datos"/>
                </form>
            </div>

            <div class="tab_content" id="tab-2-content">
                <form method="post" action="publicator.php">
                    <p class="bold">
                        Una vez que le des al botón, puede tardar mucho en cargar la página, es porque está comprimiendo
                        todo el sitio, así que espérate a que termine.
                    </p>
                    <input type="hidden" name="action" value="zip"/>
                    <input type="submit" value="Realizar copia de seguridad"/>
                </form>
            </div>

            <div class="tab_content" id="tab-3-content">
                <form method="post" action="publicator.php">
                    Host: <input type="text" name="dbhost"/><br/>
                    Usuario: <input type="text" name="dbuser"/><br/>
                    Clave: <input type="text" name="dbpass"/><br/>
                    Nombre de la BD: <input type="text" name="dbname"/><br/>
                    <p class="bold">
                        IMPORTANTE: subir fichero SQL por FTP al servidor
                    </p>
                    Nombre del fichero (Ejemplo: copia.sql):
                    <input type="text" name="filename"/><br/>
                    <input type="hidden" name="action" value="importdb"/>
                    <input type="submit" value="Importar fichero de base de datos"/>
                </form>
            </div>

            <div class="tab_content" id="tab-4-content">
                <form method="post" action="publicator.php">
                    <p class="bold">
                        Importante: subir fichero zip por FTP al servidor
                    </p>
                    Nombre del fichero (Ejemplo: site.zip):
                    <input type="text" name="filename"/></br>
                    <input type="hidden" name="action" value="unzip"/>
                    <input type="submit" value="Descomprimir"/>
                </form>
            </div>

            <br clear="all"/>
            <hr/>

            <script type="text/javascript">
                tabsClass.addTabs("tabContainer");
            </script>
        </div>
    </body>
</html>
