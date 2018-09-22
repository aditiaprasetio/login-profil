<div class="col-sm-3 content">
	<div class="list-group">
	  <a href="<?php echo site_url('dashboard'); ?>" class="list-group-item <?php if($panel_user=='dashboard') echo "active"; ?>">
		Dashboard
	  </a>
	  <a href="<?php echo site_url('pengguna/profil'); ?>" class="list-group-item <?php if($panel_user=='profil') echo "active"; ?>">Profil</a>
	  <a href="<?php echo site_url('tesminat'); ?>" class="list-group-item <?php if($panel_user=='tesminat') echo "active"; ?>">Tes Minat</a>
	  <a href="<?php echo site_url('ruangbelajar'); ?>" class="list-group-item <?php if($panel_user=='ruangbelajar') echo "active"; ?>">Ruang Belajar</a>
	  <a href="<?php echo site_url('berkas'); ?>" class="list-group-item <?php if($panel_user=='berkas') echo "active"; ?>">Berkas (Daftar Konten)</a>
	  <a href="<?php echo site_url('saku'); ?>" class="list-group-item <?php if($panel_user=='sakubiku') echo "active"; ?>">Saku Biku</a>
	  <a href="<?php echo site_url('pengguna/leaderboard'); ?>" class="list-group-item <?php if($panel_user=='leaderboard') echo "active"; ?>">Leaderboard</a>
	</div>
</div>