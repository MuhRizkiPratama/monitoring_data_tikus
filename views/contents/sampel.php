<?php

include_once (__DIR__ . "/../layouts/header.php");
require_once (__DIR__ . "/../../app/models/Sampel.php");

$sampel = new Sampel($connection);
$showAllSampel = $sampel->showAll();
$no = 1;

?>
    <main>
        <div class="card m-10 bg-base-100 shadow-sm p-5">
            <div class="card-title flex justify-between items-center">
                <h1>Data Sampel</h1>
                <button class="btn btn-primary btn-sm" onclick="create_sampel_modal.showModal()">
                    <i class="fas fa-plus"></i>
                    Tambah
                </button>
            </div>
            <div class="card-body">
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama Sampel</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php while ($data = $showAllSampel->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($data['nama_sampel']); ?></td>
                                <td><?= htmlspecialchars($data['deskripsi']); ?></td>
                                <td>
                                    <div class="flex justify-center gap-2">
                                        <button class="btn btn-warning btn-sm" onclick="update_sampel_modal_<?= $data['id_sampel']; ?>.showModal()">
                                            <i class="fas fa-pen-to-square"></i>
                                        </button>
                                        <button class="btn btn-error btn-sm" onclick="delete_sampel_modal_<?= $data['id_sampel']; ?>.showModal()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <dialog id="update_sampel_modal_<?= $data['id_sampel']; ?>" class="modal">
                                        <div class="modal-box text-left">
                                            <h3 class="text-lg font-bold mb-4">Update Data Sampel</h3>
                                            <form action="../../app/controllers/Sampel.php" method="post" class="space-y-4">
                                                <input type="hidden" name="id_sampel" value="<?= htmlspecialchars($data['id_sampel']); ?>">
                                                <div class="flex flex-col gap-2">
                                                    <label class="label" for="nama_sampel_<?= $data['id_sampel']; ?>">Nama Sampel</label>
                                                    <input type="text" name="nama_sampel" id="nama_sampel_<?= $data['id_sampel']; ?>" value="<?= htmlspecialchars($data['nama_sampel']); ?>" class="input input-bordered w-full" required>
                                                </div>
                                                <div class="flex flex-col gap-2">
                                                    <label class="label" for="deskripsi_<?= $data['id_sampel']; ?>">Deskripsi</label>
                                                    <textarea name="deskripsi" id="deskripsi_<?= $data['id_sampel']; ?>" class="textarea textarea-bordered w-full" rows="4"><?= htmlspecialchars($data['deskripsi']); ?></textarea>
                                                </div>
                                                <div class="modal-action">
                                                    <button type="button" class="btn" onclick="update_sampel_modal_<?= $data['id_sampel']; ?>.close()">Batal</button>
                                                    <button type="submit" name="updateSampel" class="btn btn-warning">
                                                        <i class="fas fa-save"></i>
                                                        Simpan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </dialog>

                                    <dialog id="delete_sampel_modal_<?= $data['id_sampel']; ?>" class="modal">
                                        <div class="modal-box text-left">
                                            <h3 class="text-lg font-bold">Hapus Data Sampel</h3>
                                            <p class="py-4">Yakin ingin menghapus sampel <?= htmlspecialchars($data['nama_sampel']); ?>?</p>
                                            <div class="modal-action">
                                                <form method="dialog">
                                                    <button class="btn">Batal</button>
                                                </form>
                                                <form action="../../app/controllers/Sampel.php" method="post">
                                                    <input type="hidden" name="id_sampel" value="<?= htmlspecialchars($data['id_sampel']); ?>">
                                                    <button type="submit" name="deleteSampel" class="btn btn-error">
                                                        <i class="fas fa-trash"></i>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </dialog>
                                </td>
                            </tr>
                            <?php }  ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <dialog id="create_sampel_modal" class="modal">
            <div class="modal-box">
                <h3 class="text-lg font-bold mb-4">Tambah Data Sampel</h3>
                <form action="../../app/controllers/Sampel.php" method="post" class="space-y-4">
                    <div class="flex flex-col gap-2">
                        <label class="label" for="nama_sampel">Nama Sampel</label>
                        <input type="text" name="nama_sampel" id="nama_sampel" class="input input-bordered w-full" required>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="label" for="deskripsi">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" class="textarea textarea-bordered w-full" rows="4"></textarea>
                    </div>
                    <div class="modal-action">
                        <button type="button" class="btn" onclick="create_sampel_modal.close()">Batal</button>
                        <button type="submit" name="createSampel" class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                            Tambah
                        </button>
                    </div>
                </form>
            </div>
        </dialog>
    </main>

<?php

include_once (__DIR__ . "/../layouts/footer.php");

?>
