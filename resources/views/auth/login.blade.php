<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — AIB Trazabilidad</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #0f1a0e; color: #e8f0e6; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        h1 { font-family: 'Times New Roman', serif; }
        .box { background: #1c2a18; border: 1px solid #2e4a28; border-radius: 16px; padding: 40px; width: 420px; max-width: 95vw; box-shadow: 0 20px 60px rgba(0,0,0,0.5); animation: cardIn 0.6s ease-out; }
        @keyframes cardIn { from{opacity:0;transform:translateY(30px) scale(0.96);} to{opacity:1;transform:none;} }
        input[type="text"], input[type="password"] { width: 100%; padding: 12px 16px; background: #162013; border: 1px solid #2e4a28; border-radius: 10px; color: #e8f0e6; font-size: 15px; outline: none; }
        input[type="text"]:focus, input[type="password"]:focus { border-color: #d4a017; }
        .btn { width: 100%; padding: 12px; background: #d4a017; color: #0f1a0e; border: none; border-radius: 10px; font-size: 15px; font-weight: 700; cursor: pointer; }
        .btn:hover { background: #b8880f; }
        .error { background: #3a1515; border: 1px solid #7f1d1d; color: #f87171; padding: 10px 14px; border-radius: 10px; font-size: 13px; margin-bottom: 16px; }
        .success { background: #14301a; border: 1px solid #166534; color: #4ade80; padding: 10px 14px; border-radius: 10px; font-size: 13px; margin-bottom: 16px; }
        .ugrid { display: grid; grid-template-columns: 1fr 1fr; gap: 6px; font-size: 11px; }
        .ucard { background: #162013; padding: 8px 10px; border-radius: 8px; border: 1px solid #2e4a28; }
        .ucard b { color: #d4a017; }
        .ucard span { color: #6b8264; }
    </style>
</head>
<body>

<div class="box">
    <div style="text-align:center;margin-bottom:32px;">
        <div style="width:60px;height:60px;background:linear-gradient(135deg,#d4a017,#b8880f);border-radius:14px;display:inline-flex;align-items:center;justify-content:center;font-size:24px;font-weight:900;color:#0f1a0e;margin-bottom:16px;">AIB</div>
        <h1 style="font-size:26px;font-weight:900;margin-bottom:4px;color:#e8f0e6;">Agroindustrias AIB</h1>
        <p style="color:#6b8264;font-size:14px;">Sistema de Trazabilidad Digital — Sede Ica</p>
    </div>

    <?php if(session('error')): ?>
        <div class="error"><i class="fas fa-exclamation-circle"></i> <?php echo session('error'); ?></div>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <div class="success"><i class="fas fa-check-circle"></i> <?php echo session('success'); ?></div>
    <?php endif; ?>

    <form method="POST" action="/login" id="loginForm">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <label style="display:block;font-size:13px;font-weight:600;color:#a3b89e;margin-bottom:5px;">Usuario</label>
        <input type="text" name="username" value="<?php echo old('username'); ?>" required autofocus placeholder="Ingrese su usuario" style="margin-bottom:16px;">
        <label style="display:block;font-size:13px;font-weight:600;color:#a3b89e;margin-bottom:5px;">Contrasena</label>
        <input type="password" name="password" required placeholder="Ingrese su contrasena" style="margin-bottom:24px;">
        <input type="submit" class="btn" value="Iniciar Sesion">
    </form>

    <div style="margin-top:24px;padding-top:16px;border-top:1px solid #2e4a28;">
        <p style="font-size:11px;color:#6b8264;text-align:center;margin-bottom:10px;text-transform:uppercase;letter-spacing:1px;font-weight:700;">Usuarios Disponibles</p>
        <div class="ugrid">
            <div class="ucard"><b>admin</b><br><span>admin2026 (Administrador)</span></div>
            <div class="ucard"><b>supervisor1</b><br><span>super2026 (Supervisor)</span></div>
            <div class="ucard"><b>opagri1</b><br><span>opera2026 (Op. agricola)</span></div>
            <div class="ucard"><b>opplanta1</b><br><span>opera2026 (Op. planta)</span></div>
            <div class="ucard"><b>empaque1</b><br><span>empa2026 (Empaquetador)</span></div>
            <div class="ucard"><b>transporte1</b><br><span>trans2026 (Transporte)</span></div>
        </div>
    </div>
</div>

</body>
</html>