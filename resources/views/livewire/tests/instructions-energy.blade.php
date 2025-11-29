<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energy Task - Instruksi</title>
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
        .arrow {
            font-size: 24px;
            color: #007bff;
        }
        .plus-sign {
            font-size: 24px;
            color: #28a745;
            font-weight: bold;
        }
        .equals-sign {
            font-size: 24px;
            color: #dc3545;
            font-weight: bold;
        }
        .result {
            font-size: 24px;
            color: #333;
            font-weight: bold;
            background-color: #ffc107;
            padding: 8px 12px;
            border-radius: 8px;
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
                // Space key - start energy task
                if (event.key === ' ' || event.code === 'Space') {
                    event.preventDefault();
                    window.location.href = '/test/energy';
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
                Pada tes ini akan muncul satu gambar kartu domino dengan jumlah titik tertentu seperti gambar di atas.
                Tugas anda adalah mengingat jumlah titik pada kartu tersebut. Pada kemunculan selanjutnya akan muncul kartu lainnya dengan jumlah titik berbeda.<br>
            </div>
            
            <div class="example-images">
                <div class="image-box">
                    <img src="/images/energy/B44.png" alt="Kartu domino pertama" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <div class="arrow">→</div>
                <div class="image-box">
                    <img src="/images/energy/B555.png" alt="Kartu domino kedua" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
            </div>
        </div>
        
        <div class="step">
            <div class="step-number">2</div>
            <div class="step-content">
                Setelah muncul kartu selanjutnya, anda diminta untuk menjumlahkan titik kartu sebelumnya dengan titik kartu setelahnya.
                Misal pada contoh dibawah ini, kemunculan pertama titik pada kartu berjumlah 4 dan titik pada kartu selanjutnya berjumlah 5. Maka anda harus menjawab dengan menekan tombol angka 9 di keyboard (4+5=9). <br>
            </div>
            
            <div class="example-images">
                <div class="image-box">
                    <img src="/images/energy/B44.png" alt="Kartu domino (4 titik)" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <div class="plus-sign">+</div>
                <div class="image-box">
                    <img src="/images/energy/B555.png" alt="Kartu domino (5 titik)" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <div class="equals-sign">=</div>
                <div class="result">9</div>
            </div>
        </div>
        
        <div class="start-instruction">
            KLIK 'SPASI' UNTUK MEMULAI
        </div>
    </div>
</body>
</html>