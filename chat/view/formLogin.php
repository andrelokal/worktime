<form action="<?php echo PATH.'/control/usuarioController.php'; ?>" method="post">
    Nome: <input type="text" name="nome" /><br><br>
    Sala: <input type="text" name="sala" /><br><br>
    Senha: <input type="password" name="senha" /><br><br>
    <input type="hidden" name="action" value="1" />
    <input type="submit" name="submit" value="Enviar" />
</form>