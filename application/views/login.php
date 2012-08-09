<!-- Login box -->
<div class="login-box">
<br><h1>Login</h1>
	<form action="<?=site_url('/principal/logar');?>" method="POST">
		<input type="hidden" name="url" id="url" value="<?=$url?>" />

		<p>E-mail</p>
		<input type="text" name="login" id="login" class="text-field" maxlength="100" />

		<p>Senha</p>
		<input type="password" name="senha" id="senha" class="text-field"/>

		<input type="submit" name="entrar" id="entrar" value="Entrar" />

		<!-- clear float -->
		<div class="clear"></div>

	</form>
</div>

<!-- Cadastro box -->
<div class="cadastro-box">
	<? $this->load->view('usuario/cadastro');?>
</div>