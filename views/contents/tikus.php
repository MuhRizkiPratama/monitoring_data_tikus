<?php

include_once (__DIR__ . "/../layouts/header.php");

?>
    <main>
        <div class="card m-10 bg-base-100 shadow-sm p-5">
            <div class="card-title flex justify-between items-center">
                <h1>Data Tikus</h1>
                <button class="btn btn-primary btn-sm" onclick="create_tikus_modal.showModal()">
                    <i class="fas fa-plus"></i>
                    Tambah
                </button>
            </div>
            <div class="card-body">
                <div class="overflow-x-auto">
                    <table class="table">
                        <!-- head -->
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>ID Sampel</th>
                                <th>Kode tikus</th>
                                <th>Jenis kelamin</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php while ($data = $showAll->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($data['id_sampel']); ?></td>
                                <td><?= htmlspecialchars($data['kode_tikus']); ?></td>
                                <td><?= htmlspecialchars($data['jenis_kelamin']); ?></td>
                                <td>
                                    <div class="flex gap-2">
                                        <button class="btn btn-warning btn-sm" onclick="update_tikus_modal_<?= $data['id_tikus']; ?>.showModal()">
                                            <i class="fas fa-pen-to-square"></i>
                                        </button>
                                        <button class="btn btn-error btn-sm" onclick="delete_tikus_modal_<?= $data['id_tikus']; ?>.showModal()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <dialog id="update_tikus_modal_<?= $data['id_tikus']; ?>" class="modal">
                                        <div class="modal-box">
                                            <h3 class="text-lg font-bold mb-4">Update Data Tikus</h3>
                                            <form action="../../app/controllers/Tikus.php" method="post" class="space-y-4">
                                                <input type="hidden" name="id_tikus" value="<?= htmlspecialchars($data['id_tikus']); ?>">
                                                <div class="flex flex-col gap-2">
                                                    <label class="label" for="id_sampel_<?= $data['id_tikus']; ?>">ID Sampel</label>
                                                    <input type="number" name="id_sampel" id="id_sampel_<?= $data['id_tikus']; ?>" value="<?= htmlspecialchars($data['id_sampel']); ?>" class="input input-bordered w-full" required>
                                                </div>
                                                <div class="flex flex-col gap-2">
                                                    <label class="label" for="kode_tikus_<?= $data['id_tikus']; ?>">Kode Tikus</label>
                                                    <input type="text" name="kode_tikus" id="kode_tikus_<?= $data['id_tikus']; ?>" value="<?= htmlspecialchars($data['kode_tikus']); ?>" class="input input-bordered w-full" required>
                                                </div>
                                                <div class="flex flex-col gap-2">
                                                    <label class="label" for="jenis_kelamin_<?= $data['id_tikus']; ?>">Jenis Kelamin</label>
                                                    <select name="jenis_kelamin" id="jenis_kelamin_<?= $data['id_tikus']; ?>" class="select select-bordered w-full" required>
                                                        <option value="jantan" <?= $data['jenis_kelamin'] === 'jantan' ? 'selected' : ''; ?>>Jantan</option>
                                                        <option value="betina" <?= $data['jenis_kelamin'] === 'betina' ? 'selected' : ''; ?>>Betina</option>
                                                    </select>
                                                </div>
                                                <div class="modal-action">
                                                    <button type="button" class="btn" onclick="update_tikus_modal_<?= $data['id_tikus']; ?>.close()">Batal</button>
                                                    <button type="submit" name="updateTikus" class="btn btn-warning">
                                                        <i class="fas fa-save"></i>
                                                        Simpan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </dialog>

                                    <dialog id="delete_tikus_modal_<?= $data['id_tikus']; ?>" class="modal">
                                        <div class="modal-box">
                                            <h3 class="text-lg font-bold">Hapus Data Tikus</h3>
                                            <p class="py-4">Yakin ingin menghapus data tikus <?= htmlspecialchars($data['kode_tikus']); ?>?</p>
                                            <div class="modal-action">
                                                <form method="dialog">
                                                    <button class="btn">Batal</button>
                                                </form>
                                                <form action="../../app/controllers/Tikus.php" method="post">
                                                    <input type="hidden" name="id_tikus" value="<?= htmlspecialchars($data['id_tikus']); ?>">
                                                    <button type="submit" name="deleteTikus" class="btn btn-error">
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

        <dialog id="create_tikus_modal" class="modal">
            <div class="modal-box">
                <h3 class="text-lg font-bold mb-4">Tambah Data Tikus</h3>
                <form action="../../app/controllers/Tikus.php" method="post" class="space-y-4">
                    <div class="flex flex-col gap-2">
                        <label class="label" for="id_sampel">ID Sampel</label>
                        <input type="number" name="id_sampel" id="id_sampel" class="input input-bordered w-full" required>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="label" for="kode_tikus">Kode Tikus</label>
                        <input type="text" name="kode_tikus" id="kode_tikus" class="input input-bordered w-full" required>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="label" for="jenis_kelamin">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="select select-bordered w-full" required>
                            <option value="jantan">Jantan</option>
                            <option value="betina">Betina</option>
                        </select>
                    </div>
                    <div class="modal-action">
                        <button type="button" class="btn" onclick="create_tikus_modal.close()">Batal</button>
                        <button type="submit" name="createTikus" class="btn btn-primary">
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
