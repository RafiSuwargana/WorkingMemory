<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Speed Task - Instruksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            max-width: 900px;
            width: 90%;
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            color: #333;
            margin-bottom: 30px;
            font-size: 32px;
            font-weight: bold;
        }
        .step {
            background-color: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 25px;
            margin: 25px 0;
            text-align: left;
        }
        .step-number {
            background-color: #007bff;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 15px;
        }
        .step-content {
            font-size: 16px;
            color: #444;
            line-height: 1.8;
        }
        .example-images {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 20px 0;
            align-items: center;
        }
        .image-box {
            width: 120px;
            height: 120px;
            background-color: #e9ecef;
            border: 2px solid #6c757d;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
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
        .arrow {
            font-size: 24px;
            color: #007bff;
        }
        .start-instruction {
            background-color: #28a745;
            color: white;
            padding: 20px;
            border-radius: 10px;
            font-size: 20px;
            font-weight: bold;
            margin-top: 30px;
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
                // Space key - start speed task
                if (event.key === ' ' || event.code === 'Space') {
                    event.preventDefault();
                    window.location.href = '/test/speed';
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
                Pada tes ini akan muncul dua gambar yang berbeda seperti gambar di atas.<br>
                Tugas anda adalah mengingat kedua gambar tersebut, karena pada tampilan selanjutnya, akan muncul dua gambar lainnya yang salah satunya muncul kembali.
            </div>
            
            <div class="example-images">
                <div class="image-box">
                    <div class="image-label">1</div>
                    <img src="/images/speed/1.png" alt="Gambar 1" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <div class="image-box">
                    <div class="image-label">2</div>
                    <img src="/images/speed/12.png" alt="Gambar 2" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
            </div>
        </div>
        
        <div class="step">
            <div class="step-number">2</div>
            <div class="step-content">
                Pada kemunculan selanjutnya, akan muncul dua gambar berbeda yang salah satunya telah muncul pada tampilan sebelumnya.<br>
                Tugas anda adalah mengklik gambar mana yang kembali muncul, dengan memijit tombol <strong>1</strong> atau <strong>2</strong> di keyboard.
            </div>
            
            <div class="example-images">
                <div class="image-box" style="position: relative;">
                    <div class="image-label" style="background: #28a745;">1</div>
                    <img src="/images/speed/12.png" alt="Gambar 1 (BENAR)" style="width: 100%; height: 100%; object-fit: contain;">
                    <div style="position: absolute; bottom: 5px; left: 0; right: 0; background: rgba(40, 167, 69, 0.9); color: white; font-size: 12px; font-weight: bold; padding: 2px;">BENAR</div>
                </div>
                <div class="image-box">
                    <div class="image-label">2</div>
                    <img src="/images/speed/13.png" alt="Gambar 2" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
            </div>
            
            <p style="margin-top: 15px; color: #007bff; font-weight: bold;">
                Pada contoh di bawah ini, gambar nomor 1 adalah jawaban yang benar karena sama seperti gambar nomor dua pada kemunculan sebelumnya.
            </p>
        </div>
        
        <div class="start-instruction">
            KLIK 'SPASI' UNTUK MEMULAI
        </div>
    </div>
</body>
</html>
