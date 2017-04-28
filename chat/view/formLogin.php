<form action="control/usuarioController.php" method="post">
    <label><span>Nome:</span><input type="text" name="nome" /></label>
    <label><span>Sala:</span><input type="text" name="sala" /></label>
    <label><span>Senha:</span><input type="password" name="senha" /></label>
    <label>Cor:</label><select name="cor">
            <option value="#000000">Preto</option>
            <option value="#0000CD" style="color: #0000CD;">Azul</option>
            <option value="#006400" style="color: #006400;">Verde</option>
            <option value="#DAA520" style="color: #DAA520;">Amarelo</option>
            <option value="#FF0000" style="color: #FF0000;">Vermelho</option>
            <option value="#FF0000" style="color: #FF4500;">Laranja</option>
            <option value="#FF00FF" style="color: #FF00FF;">Rosa</option>
            <option value="#9400D3" style="color: #9400D3;">Roxo</option>
        </select></br></br>
    <input type="hidden" name="action" value="1" />
    <input type="submit" name="submit" value="Entrar" />
</form>