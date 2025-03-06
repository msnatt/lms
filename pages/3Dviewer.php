<!DOCTYPE html>
<html lang="th">

<head>
    <?php include "../include/ref.html"; ?>
    <?php include "../include/style.html"; ?>
    <title>3D Model Viewer</title>
</head>

<body>
    <div class="d-flex">
        <div id="dropZone">ลากไฟล์หรือโฟลเดอร์มาที่นี่</div>
        <input type="file" id="upload" accept=".glb, .gltf, .bin, .jpg, .png" multiple />
        <div id="viewer"></div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/three@0.128/examples/js/loaders/GLTFLoader.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/three@0.128/examples/js/controls/OrbitControls.js"></script>

        <script>
            let controls;

            const viewer = document.getElementById('viewer');

            function init() {
                // สร้างฉาก
                scene = new THREE.Scene();

                // สร้างกล้อง
                camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
                camera.position.set(0, 2, 5);

                // สร้าง renderer
                renderer = new THREE.WebGLRenderer({
                    antialias: true
                });
                renderer.setSize(window.innerWidth / 2, window.innerHeight);
                viewer.appendChild(renderer.domElement);

                // สร้างแสง
                const light = new THREE.DirectionalLight(0xffffff, 10);
                light.position.set(1, 1, 1).normalize();
                scene.add(light);

                // สร้าง GLTFLoader
                loader = new THREE.GLTFLoader();

                // สร้าง OrbitControls
                controls = new THREE.OrbitControls(camera, renderer.domElement);
                controls.enableDamping = true; // ทำให้การหมุนกล้องนุ่มนวล
                controls.dampingFactor = 0.25;
                controls.screenSpacePanning = false;
                controls.maxDistance = 10; // จำกัดระยะซูม

                // เพิ่ม event listener สำหรับการอัปโหลดไฟล์
                document.getElementById('upload').addEventListener('change', handleFileUpload, false);

                // เริ่มการเรนเดอร์
                animate();
            }


            function animate() {
                requestAnimationFrame(animate);
                controls.update(); // อัปเดตการควบคุมกล้อง
                renderer.render(scene, camera);
            }


            const dropZone = document.getElementById('dropZone');

            dropZone.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropZone.style.backgroundColor = 'blue';
            });

            dropZone.addEventListener('dragleave', () => {
                dropZone.style.borderColor = '#ccc';
            });

            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.style.borderColor = '#ccc';
                handleFileUpload(e.dataTransfer.files);
            });

            document.getElementById('upload').addEventListener('change', (e) => {
                handleFileUpload(e.target.files);
            });

            function handleFileUpload(files) {
                const fileMap = {};
                let mainFile = null;

                for (let file of files) {
                    fileMap[file.name] = file;
                    if (file.name.endsWith('.gltf') || file.name.endsWith('.glb')) {
                        mainFile = file;
                    }
                }

                if (!mainFile) {
                    console.error('ไม่พบไฟล์ .gltf หรือ .glb');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    if (mainFile.name.endsWith('.gltf')) {
                        const baseURL = URL.createObjectURL(mainFile);
                        loader.load(baseURL, function(gltf) {
                            clearScene();
                            scene.add(gltf.scene);
                        }, undefined, function(error) {
                            console.error('เกิดข้อผิดพลาดในการโหลด:', error);
                        });
                    } else if (mainFile.name.endsWith('.glb')) {
                        const arrayBuffer = e.target.result;
                        loader.parse(arrayBuffer, '', function(gltf) {
                            clearScene();
                            scene.add(gltf.scene);
                        }, function(error) {
                            console.error('เกิดข้อผิดพลาดในการโหลด:', error);
                        });
                    }
                };

                if (mainFile.name.endsWith('.glb')) {
                    reader.readAsArrayBuffer(mainFile);
                } else {
                    reader.readAsDataURL(mainFile);
                }
            }

            function clearScene() {
                scene.children.forEach(child => {
                    if (!child.isLight && !child.isCamera) {
                        scene.remove(child);
                    }
                });
            }

            init();
        </script>
    <?php include "../include/scriptjs.html"; ?>
    </div>

</body>

</html>