



<aside id="sidebar" class="column">
    <form class="quick_search">
        <input type="text" value="Quick Search" onfocus="if (!this._haschanged) {
                    this.value = ''
                }
                ;
                this._haschanged = true;">
    </form>
    <hr/>
    <h3>Información General</h3>
    <ul class="toggle">
        <li class="icn_new_article"><a href="<?php echo base_url() ?>adm_repo/registrar_repo/">Registrar repositorio</a></li>
        <li class="icn_edit_article"><a href="#">Modificar Repositorio</a></li>
        <li class="icn_categories"><a href="#">Conlsultar Repositorios</a></li>
        <li class="icn_tags"><a href="#">Tags</a></li>
    </ul>
    <h3>Usuarios</h3>
    <ul class="toggle">
        <li class="icn_add_user"><a href="#">Crear un nuevo usuario</a></li>
        <li class="icn_view_users"><a href="#">Lista de usuarios</a></li>
        <li class="icn_profile"><a href="#">Mi cuenta</a></li>
    </ul>
    <h3>Admin</h3>
    <ul class="toggle">
        <li class="icn_settings"><a href="#">Opciones</a></li>
        <li class="icn_security"><a href="#">Seguridad</a></li>
        <li class="icn_jump_back"><a href="#">Logout</a></li>
    </ul>

    <footer>
        <hr />
        <p><strong>Copyright &copy; 2013  FROAC</strong></p>
    </footer>
</aside><!-- end of sidebar -->