<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capacity Task - Instruksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            line-height: 1.4;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .container {
            max-width: 900px;
            width: 90%;
            height: 85vh;
            background-color: white;
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        h1 {
            color: #333;
            margin-bottom: 15px;
            font-size: 2em;
            font-size: 32px;
            font-weight: bold;
        }
        .step {
            background-color: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin: 15px 0;
            text-align: left;
        }
        .step-number {
            background-color: #007bff;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .step-content {
            font-size: 14px;
            color: #444;
            line-height: 1.4;
        }
        .example-images {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 10px 0;
            align-items: center;
        }
        .image-box {
            width: 80px;
            height: 80px;
            background-color: #e9ecef;
            border: 2px solid #6c757d;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: #6c757d;
            position: relative;
        }
        .image-label {
            position: absolute;
            top: -10px;
            left: -10px;
            background: #007bff;
            color: white;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 12px;
        }
        .grid-8 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            max-width: 400px;
            margin: 0 auto;
        }
        .grid-item {
            width: 60px;
            height: 60px;
            background-color: #e9ecef;
            border: 2px solid #6c757d;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: #6c757d;
            position: relative;
        }
        .grid-item.highlighted {
            border-color: #28a745;
            background-color: #d4edda;
        }
        .start-instruction {
            background-color: #28a745;
            color: white;
            padding: 12px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: bold;
            margin-top: 10px;
        }
        .logout-link {
            position: absolute;
            top: 20px;
            right: 20px;
            color: #dc3545;
            text-decoration: none;
            font-weight: bold;
        }
        .logout-link:hover {
            text-decoration: underline;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('keydown', function(event) {
                // Space key - start capacity task
                if (event.key === ' ' || event.code === 'Space') {
                    event.preventDefault();
                    window.location.href = '/test/capacity';
                }
                
                // Escape key - back to dashboard
                if (event.key === 'Escape') {
                    event.preventDefault();
                    if (confirm('Kembali ke dashboard?')) {
                        window.location.href = '/dashboard';
                    }
                }
            });
        });
        
        function logout() {
            if (confirm('Apakah Anda yakin ingin keluar?')) {
                window.location.href = '/logout';
            }
        }
    </script>
</head>
<body>
    <a href="#" onclick="logout()" class="logout-link">Keluar</a>
    
    <div class="container">
        <h1>INSTRUKSI TES</h1>
        
        <div class="step">
            <div class="step-number">1</div>
            <div class="step-content">
                Pada tes ini akan muncul 2–5 gambar berbeda seperti gambar di bawah.<br>
                Tugas anda adalah mengingat gambar-gambar tersebut dalam waktu 10 detik.
            </div>
            
            <div class="example-images">
                <div class="image-box">
                    <img src="/images/capacity/25.png" alt="Gambar" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <div class="image-box">
                    <img src="/images/capacity/21.png" alt="Gambar" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <div class="image-box">
                    <img src="/images/capacity/11.png" alt="Gambar" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
            </div>
            
            <p style="margin-top: 10px; color: #444; font-size: 14px; line-height: 1.4;">
                Setelah waktu 10 detik habis, akan muncul 8 gambar berurutan dari gambar 1 hingga gambar 8 seperti pada poin 2.
            </p>
        </div>
        
        <div class="step">
            <div class="step-number">2</div>
            <div class="step-content">
                Setelah muncul gambar seperti di bawah ini, tugas anda adalah menjawab dengan klik gambar yang tadi anda ingat.<br><br>
                Pada contoh di bawah ini, gambar yang muncul sebelumnya adalah pada angka 1, 2, dan 6.<br>
                Karena itu anda harus klik gambar 1,2,6
            </div>
            
            <div class="grid-8">
                <div class="grid-item highlighted">
                    <img src="/images/capacity/25.png" alt="1" style="width: 100%; height: 100%; object-fit: contain;">
                    <div style="position: absolute; bottom: 2px; font-size: 12px; font-weight: bold; color: #333; background-color: rgba(255,255,255,0.8); padding: 1px 3px; border-radius: 2px;">1</div>
                </div>
                <div class="grid-item highlighted">
                    <img src="/images/capacity/21.png" alt="2" style="width: 100%; height: 100%; object-fit: contain;">
                    <div style="position: absolute; bottom: 2px; font-size: 12px; font-weight: bold; color: #333; background-color: rgba(255,255,255,0.8); padding: 1px 3px; border-radius: 2px;">2</div>
                </div>
                <div class="grid-item">
                    <img src="/images/capacity/20.png" alt="3" style="width: 100%; height: 100%; object-fit: contain;">
                    <div style="position: absolute; bottom: 2px; font-size: 12px; font-weight: bold; color: #333; background-color: rgba(255,255,255,0.8); padding: 1px 3px; border-radius: 2px;">3</div>
                </div>
                <div class="grid-item">
                    <img src="/images/capacity/1.png" alt="4" style="width: 100%; height: 100%; object-fit: contain;">
                    <div style="position: absolute; bottom: 2px; font-size: 12px; font-weight: bold; color: #333; background-color: rgba(255,255,255,0.8); padding: 1px 3px; border-radius: 2px;">4</div>
                </div>
                <div class="grid-item">
                    <img src="/images/capacity/9.png" alt="5" style="width: 100%; height: 100%; object-fit: contain;">
                    <div style="position: absolute; bottom: 2px; font-size: 12px; font-weight: bold; color: #333; background-color: rgba(255,255,255,0.8); padding: 1px 3px; border-radius: 2px;">5</div>
                </div>
                <div class="grid-item highlighted">
                    <img src="/images/capacity/11.png" alt="6" style="width: 100%; height: 100%; object-fit: contain;">
                    <div style="position: absolute; bottom: 2px; font-size: 12px; font-weight: bold; color: #333; background-color: rgba(255,255,255,0.8); padding: 1px 3px; border-radius: 2px;">6</div>
                </div>
                <div class="grid-item">
                    <img src="/images/capacity/13.png" alt="7" style="width: 100%; height: 100%; object-fit: contain;">
                    <div style="position: absolute; bottom: 2px; font-size: 12px; font-weight: bold; color: #333; background-color: rgba(255,255,255,0.8); padding: 1px 3px; border-radius: 2px;">7</div>
                </div>
                <div class="grid-item">
                    <img src="/images/capacity/3.png" alt="8" style="width: 100%; height: 100%; object-fit: contain;">
                    <div style="position: absolute; bottom: 2px; font-size: 12px; font-weight: bold; color: #333; background-color: rgba(255,255,255,0.8); padding: 1px 3px; border-radius: 2px;">8</div>
                </div>
            </div>
            
            <p style="margin-top: 8px; color: #007bff; font-weight: bold; font-size: 13px; line-height: 1.3;">
                Pada contoh di atas, gambar 1, 2, dan 6 di-highlight hijau karena merupakan jawaban yang benar.
            </p>
        </div>
        
        <div class="start-instruction">
            KLIK 'SPASI' UNTUK MEMULAI
        </div>
    </div>
</body>
</html>