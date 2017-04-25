<form action="control/usuarioController.php" method="post">
    <label>Nome:</label> <input type="text" name="nome" /><br><br>
    <label>Sala:</label> <input type="text" name="sala" /><br><br>
    <label>Senha:</label> <input type="password" name="senha" /><br><br>
    <input type="hidden" name="action" value="1" />
    <input type="submit" name="submit" value="Enviar" />
</form>