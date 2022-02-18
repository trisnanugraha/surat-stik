<?php
$apl = $this->db->get("aplikasi")->row();
?>
<!-- main-header navbar navbar-expand navbar-default navbar-dark navbar-cyan -->


<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url(); ?>" class="brand-link">
        <img src="<?php echo base_url(); ?>assets/foto/logo/<?php echo $apl->logo; ?>" alt="<?php echo $apl->title; ?>" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?php echo  $apl->title; ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar ">
        <!-- Sidebar user panel (optional) -->
        <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?php echo base_url(); ?>assets/foto/user/<?php echo $this->session->userdata['image']; ?>" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?php echo $this->session->userdata['full_name']; ?></a>
      </div>
    </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <?php
                // data main menu
                $idlevel  = $this->session->userdata['id_level'];
                $main_menu = $this->db->select('b.nama_menu,b.icon,b.link,b.id_menu');
                $main_menu = $this->db->join('tbl_menu b', 'a.id_menu=b.id_menu');
                $main_menu = $this->db->join('tbl_userlevel c', 'a.id_level=c.id_level');
                $main_menu = $this->db->where('a.id_level', $idlevel);
                $main_menu = $this->db->where('a.view_level', 'Y');
                $main_menu = $this->db->order_by('urutan ASC');
                $main_menu = $this->db->get('tbl_akses_menu a');
                foreach ($main_menu->result() as $main) {
                    $idlevel  = $this->session->userdata['id_level'];

                    $sub_menu = $this->db->join('tbl_submenu b', 'a.id_submenu=b.id_submenu');
                    $sub_menu = $this->db->where('a.id_level', $idlevel);
                    $sub_menu = $this->db->where('b.id_menu', $main->id_menu);
                    $sub_menu = $this->db->where('a.view_level', 'Y');
                    $sub_menu = $this->db->order_by('b.nama_submenu', 'ASC');
                    $sub_menu = $this->db->get('tbl_akses_submenu a');

                    if ($sub_menu->num_rows() > 0) {
                        $segmen   = $this->uri->segment(1);
                        $submenu = $this->db->select('link');
                        $submenu = $this->db->where('id_menu', $main->id_menu);
                        $submenu = $this->db->where('link', $segmen);
                        $submenu = $this->db->get('tbl_submenu');
                        $link = '';
                        if ($submenu->num_rows() > 0) {
                            $sub = $submenu->row();
                            $link = $sub->link;
                        }
                ?>
                        <li class="nav-item has-treeview <?= $this->uri->segment(1) == $link ? 'menu-open' : '' ?>">

                            <a href="<?= $main->link; ?>" <?= $this->uri->segment(1) == $link ? 'class="nav-link active"' : 'class="nav-link"' ?>>
                                <i class="nav-icon <?= $main->icon ?>"></i>
                                <p>
                                    <?php echo $main->nama_menu; ?>
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <?php foreach ($sub_menu->result() as $sub) : ?>
                                    <li class="nav-item">
                                        <a href="<?= $sub->link; ?>" <?= $this->uri->segment(1) == $sub->link ? 'class="nav-link active"' : 'class="nav-link"' ?>>
                                            <i class="<?= $sub->icon; ?> nav-icon"></i>
                                            <p><?php echo $sub->nama_submenu; ?></p>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>

                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a href="<?= $main->link; ?>" <?= $this->uri->segment(1) == $main->link ? 'class="nav-link active"' : 'class="nav-link"' ?>>
                                <i class="nav-icon fas <?= $main->icon ?>"></i>
                                <p>
                                    <?php echo $main->nama_menu; ?>
                                </p>
                            </a>
                        </li>
                <?php }
                } ?>
                <li class="nav-item">
                    <a href="<?= base_url('login/logout') ?>" class="nav-link">
                        <i class="nav-icon fas  fa-sign-out-alt text-bold"></i>
                        <p>Keluar</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>