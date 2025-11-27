<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Working Memory Task - Instruksi Umum</title>
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
            max-width: 800px;
            width: 90%;
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 28px;
        }
        .instruction-text {
            color: #444;
            font-size: 16px;
            text-align: center;
            margin-bottom: 20px;
        }
        .highlight {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
        }
        .navigation-info {
            background-color: #e8f4f8;
            border: 1px solid #bee5eb;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
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
            let isListening = true;
            
            document.addEventListener('keydown', function(event) {
                if (!isListening) return;
                
                // Enter key - proceed to instructions
                if (event.key === 'Enter') {
                    event.preventDefault();
                    window.location.href = '/instructionspeed';
                }
                
                // Escape key
                if (event.key === 'Escape') {
                    event.preventDefault();
                    isListening = false;
                    if (confirm('Apakah Anda yakin ingin keluar dari test?')) {
                        // Wait for Q key
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'q' || e.key === 'Q') {
                                // Redirect to logout
                                window.location.href = '/logout';
                            } else if (e.key === ' ') {
                                // Space to continue
                                isListening = true;
                            }
                        });
                    } else {
                        isListening = true;
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
        <h1>Instruksi Umum</h1>
        
        <div class="instruction-text">
            <p>Pada tes ini, anda akan disajikan tiga sesi pengukuran yang meliputi <strong>Tes Kecepatan</strong>, <strong>Tes Energi</strong>, dan <strong>Tes Kapasitas Memori Kerja</strong>.</p>
            
            <p>Setiap tes berisi 50 stimulus yang anda harus jawab dengan mengklik tombol di keyboard sesuai perintah pada setiap tesnya.</p>
            
            <p>Anda tidak boleh berhenti pada saat sesi berlangsung. Namun, jika harus berhenti, anda cukup mengklik tombol <strong>'Esc'</strong> pada keyboard, kemudian klik tombol <strong>'spasi'</strong> jika akan melanjutkan.</p>
            
            <p>Setiap stimulus yang muncul memiliki durasi tertentu yang akan terus berjalan meski respon anda keliru atau tidak merespon. Anda diminta untuk merespon secepat mungkin ketika anda mendapatkan jawabannya.</p>
            
            <p>Jika ada pertanyaan, silakan anda bertanya pada fasilitator.</p>
        </div>
        
        <div class="highlight">
            <p><strong>Jika anda sudah mengerti, klik 'Enter' untuk melanjutkan dan merupakan tanda anda menyetujui untuk berpartisipasi pada tes ini.</strong></p>
        </div>
        
        <div class="navigation-info">
            <p><strong>Jika anda tidak akan berpartisipasi, klik 'Esc' dan kemudian klik 'Q'.</strong></p>
        </div>
    </div>
</body>
</html>
