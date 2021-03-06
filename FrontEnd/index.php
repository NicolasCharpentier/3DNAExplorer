<?php

function        co_mysql()
{
    $co = mysql_connect("localhost:/Applications/MAMP/tmp/mysql/mysql.sock", "root", "root"); // Pour MAC
    //$co = mysql_connect("localhost", "root", "root"); // Pour Windows
    if (!$co)
        echo "Erreur : ". mysql_error(). "\n";
    else
        echo "Connexion mysql : OK!\n";
    $select_db = mysql_select_db("bioptimize", $co);
    if (!$select_db)
        echo "Erreur : ". mysql_error(). "\n";
    else
        echo "Connexion database : OK!\n";
    return ($co);
}
function        disco_mysql($co)
{
    if (mysql_close($co))
        echo "Déconnexion reussite !\n";
    else
        echo "Erreur : ". mysql_error();
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>3DNA explorer</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php 
        co_mysql();
        $req_locus = mysql_query("SELECT base FROM seq_locus WHERE id_locus = 0");
        while ($aff_locus = mysql_fetch_array($req_locus))
        {
            $test .= $aff_locus['base'];
        }
        disco_mysql();
    ?>

    <div id="logo"><img src="logo.png" alt="3DNA logo"></div>
    <ul>
       <li id="a">A</li>
       <li id="t">T</li>
       <li id="g">G</li>
       <li id="c">C</li>
       <li id="error">else</li>
       <li class="standard"><span>Complementary nucleotides are 40% transparent.</span></li>
   </ul>
   <script src="three.min.js"></script>
   <script src="TrackballControls.js"></script>
   <script src="dat.gui.min.js"></script>
   <script type="text/javascript">
    var camera, controls, scene, renderer;

    init();
    animate();

    function init(){
            //creates camera
            camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 1, 10000);
            //sets initial camera position
            camera.position.z = 700;

            //sets trackball controls to camera
            controls = new THREE.TrackballControls( camera );
            controls.addEventListener('change', render);

            //creates scene
            scene = new THREE.Scene();

            //CUBE
            var geometry = new THREE.BoxGeometry(100,100,100);//creates new cube and sets its dimensions
            var nucleobase_position = 0;

            var test_string = "<?php echo $test; ?>"//18 characters
            //var test_string = <?php echo $ma_varphp; ?>;
            var locus_length = test_string.length;
            //NUCLEOBASE ADDITION
            for (var i = 0; i<locus_length; i++){
                    var base = test_string.charAt(i);//tests if the read character is a, c, g or t

                    if (base == 'a') {
                        material1 = new THREE.MeshPhongMaterial( { color: '#7908AA', specular: '#fff', shininess: 5 } );//nucleotide color
                        //material2 = new THREE.MeshPhongMaterial( { color: '#FF7C00', specular: '#fff', shininess: 1, opacity: 0.6, transparent: true } );//complementary nucleotide color
                    }
                    else if (base == 't') {
                        material1 = new THREE.MeshPhongMaterial( { color: '#FF7C00', specular: '#fff', shininess: 5 } );
                        //material2 = new THREE.MeshPhongMaterial( { color: '#7908AA', specular: '#fff', shininess: 1 , opacity: 0.6, transparent: true } );
                    }
                    else if (base == 'g') {
                        material1 = new THREE.MeshPhongMaterial( { color: '#04859D', specular: '#fff', shininess: 5 } );
                        //material2 = new THREE.MeshPhongMaterial( { color: '#F3FD00', specular: '#fff', shininess: 1 , opacity: 0.6, transparent: true } );
                    }
                    else if (base == 'c') {
                        material1 = new THREE.MeshPhongMaterial( { color: '#F3FD00', specular: '#fff', shininess: 5 } );
                        //material2 = new THREE.MeshPhongMaterial( { color: '#04859D', specular: '#fff', shininess: 1 , opacity: 0.6, transparent: true } );
                    }
                    else {
                        material1 = new THREE.MeshPhongMaterial( { color: 'grey', specular: '#fff', shininess: 5 } );
                        //material2 = new THREE.MeshPhongMaterial( { color: 'grey', specular: '#fff', shininess: 1 , opacity: 0.6, transparent: true } );
                    }

                    var mesh = new THREE.Mesh(geometry, material1);//generates cube mesh
                    mesh.position.y = 90
                    mesh.position.x += 130;

                    //var opposite_mesh = new THREE.Mesh(geometry, material2);
                    //opposite_mesh.position.y = -90;
                    //opposite_mesh.position.x += 130;

                    var row = new THREE.Object3D();
                    row.add(mesh);
                    //row.add(opposite_mesh);

                    row.position.x = nucleobase_position;
                    //row.rotation.x = 30*i * Math.PI/180;//rotates row by 30 degrees each time
                    nucleobase_position += 130;//adds 30 units spacing between cube (which have an initial size of 100)

                    scene.add(row);//adds final mesh to the scene
                };

            //LIGHT
            //creates lights
            var hemiLight = new THREE.HemisphereLight("#fff", "#fff", 0.5);
            var directional_light = new THREE.DirectionalLight( 'grey', 0.5 );
            //sets light position
            hemiLight.position.set(0, 500, 0);
            hemiLight.visible = true;
            directional_light.position.set(50,50,100).normalize();
            //adds lights to the scene
            scene.add(hemiLight);
            scene.add(directional_light);

            //RENDERER
            //creates renderer
            renderer = new THREE.WebGLRenderer( { alpha: true, antialias: true } );
            renderer.setClearColor( '#ffffff' );
            //sets renderer size
            renderer.setSize(window.innerWidth, window.innerHeight)
            document.body.appendChild(renderer.domElement);
        }

        function animate(){
            requestAnimationFrame( animate );
            controls.update();
        }

        function render(){
            renderer.render( scene, camera );
        }
        render();
    </script>
</body>
</html>
