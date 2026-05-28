<?php

include_once (__DIR__ . "/../layouts/header.php");
require_once (__DIR__ . "/../../app/models/Monitoring.php");

$monitoring = new Monitoring($connection);
$showMonitoring = $monitoring->showAll();
$monitoringData = [];

while ($dataMonitoring = $showMonitoring->fetch_assoc()) {
    $idTikus = $dataMonitoring['id_tikus'];
    $hariKe = $dataMonitoring['hari_ke'];

    if (!isset($monitoringData[$idTikus][$hariKe])) {
        $monitoringData[$idTikus][$hariKe] = $dataMonitoring;
    }
}

$showAllTikus = $tikus->showAll();
$dataTikus = [];

while ($rowTikus = $showAllTikus->fetch_assoc()) {
    $dataTikus[] = $rowTikus;
}

$dataTikus = array_slice($dataTikus, 0, 28);
$selectedTikusId = $_GET['id_tikus'] ?? ($dataTikus[0]['id_tikus'] ?? '');
$selectedTikus = null;

foreach ($dataTikus as $rowTikus) {
    if ((string) $rowTikus['id_tikus'] === (string) $selectedTikusId) {
        $selectedTikus = $rowTikus;
        break;
    }
}

$selectedMonitoringData = $selectedTikus ? ($monitoringData[$selectedTikus['id_tikus']] ?? []) : [];
$totalTerisi = count($selectedMonitoringData);
$today = date('Y-m-d');

function getIritasiInterpretation($totalSkor){
    if ($totalSkor === 0) {
        return 'Tidak mengiritasi';
    }

    if ($totalSkor <= 2) {
        return 'Iritasi sangat ringan';
    }

    if ($totalSkor <= 4) {
        return 'Iritasi ringan';
    }

    if ($totalSkor <= 6) {
        return 'Iritasi sedang';
    }

    return 'Iritasi berat';
}

$eritemaOptions = [
    0 => 'Skor 0: Tidak ada eritema (kulit normal)',
    1 => 'Skor 1: Eritema sangat ringan (nyaris tidak terlihat)',
    2 => 'Skor 2: Eritema ringan hingga jelas terlihat',
    3 => 'Skor 3: Eritema sedang hingga berat',
    4 => 'Skor 4: Eritema berat disertai kerusakan jaringan',
];

$edemaOptions = [
    0 => 'Skor 0: Tidak ada edema',
    1 => 'Skor 1: Edema sangat ringan (nyaris tidak terlihat)',
    2 => 'Skor 2: Edema ringan',
    3 => 'Skor 3: Edema sedang (tepi kulit terangkat jelas)',
    4 => 'Skor 4: Edema berat (pembengkakan luas)',
];

?>
    <main>
        <div class="card m-10 bg-base-100 shadow-sm p-5">
            <div class="card-title flex justify-between items-center">
                <div>
                    <h1>Data Monitoring</h1>
                    <p class="text-sm font-normal opacity-70">Pilih satu tikus untuk melihat monitoring 14 hari</p>
                </div>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="stats bg-base-200 shadow-sm">
                        <div class="stat">
                            <div class="stat-figure text-primary"><i class="fas fa-paw text-xl"></i></div>
                            <div class="stat-title">Tikus</div>
                            <div class="stat-value text-primary"><?= count($dataTikus); ?></div>
                        </div>
                    </div>
                    <div class="stats bg-base-200 shadow-sm">
                        <div class="stat">
                            <div class="stat-figure text-secondary"><i class="fas fa-calendar-days text-xl"></i></div>
                            <div class="stat-title">Hari</div>
                            <div class="stat-value text-secondary">14</div>
                        </div>
                    </div>
                    <div class="stats bg-base-200 shadow-sm">
                        <div class="stat">
                            <div class="stat-figure text-accent"><i class="fas fa-check-circle text-xl"></i></div>
                            <div class="stat-title">Terisi</div>
                            <div class="stat-value text-accent"><?= $totalTerisi; ?></div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="flex flex-col gap-2">
                        <label class="label" for="filter_tikus">Pilih Tikus</label>
                        <select id="filter_tikus" class="select select-bordered w-full" onchange="changeSelectedTikus(this.value)">
                            <?php foreach ($dataTikus as $rowTikus) { ?>
                                <option value="<?= htmlspecialchars($rowTikus['id_tikus']); ?>" <?= (string) $rowTikus['id_tikus'] === (string) $selectedTikusId ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($rowTikus['kode_tikus']); ?> - <?= htmlspecialchars($rowTikus['jenis_kelamin']); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <?php if ($selectedTikus) { ?>
                        <div class="rounded-lg bg-base-200 p-4">
                            <div class="text-sm opacity-60">Kode Tikus</div>
                            <div class="font-bold"><?= htmlspecialchars($selectedTikus['kode_tikus']); ?></div>
                        </div>
                        <div class="rounded-lg bg-base-200 p-4">
                            <div class="text-sm opacity-60">ID Sampel</div>
                            <div class="font-bold"><?= htmlspecialchars($selectedTikus['id_sampel']); ?></div>
                        </div>
                    <?php } ?>
                </div>

                <div class="overflow-x-auto">
                    <table class="table table-zebra">
                        <thead class="text-center">
                            <tr>
                                <th>Hari</th>
                                <th>Tanggal Oles</th>
                                <th>Berat Badan</th>
                                <th>Skor Eritema</th>
                                <th>Skor Edema</th>
                                <th>Total Iritasi</th>
                                <th>Interpretasi</th>
                                <th>Foto Berat</th>
                                <th>Foto Kulit Sebelum Oles</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php for ($hari = 1; $hari <= 14; $hari++) {
                                $cellData = $selectedMonitoringData[$hari] ?? null;
                            ?>
                            <tr>
                                <td>
                                    <span class="badge badge-primary">Hari <?= $hari; ?></span>
                                </td>
                                <?php if ($cellData) { ?>
                                    <?php
                                        $skorEritema = (int) ($cellData['skor_eritema'] ?? 0);
                                        $skorEdema = (int) ($cellData['skor_edema'] ?? 0);
                                        $totalSkorIritasi = $skorEritema + $skorEdema;
                                    ?>
                                    <td><?= htmlspecialchars($cellData['tanggal']); ?></td>
                                    <td><?= htmlspecialchars($cellData['berat_badan']); ?> gram</td>
                                    <td><span class="badge badge-outline"><?= $skorEritema; ?></span></td>
                                    <td><span class="badge badge-outline"><?= $skorEdema; ?></span></td>
                                    <td><span class="badge badge-primary"><?= $totalSkorIritasi; ?></span></td>
                                    <td><?= htmlspecialchars(getIritasiInterpretation($totalSkorIritasi)); ?></td>
                                    <td>
                                        <?php if ($cellData['foto_berat']) { ?>
                                            <button type="button" class="btn btn-ghost btn-sm" onclick="openPhotoModal(<?= htmlspecialchars(json_encode('Foto Berat Badan'), ENT_QUOTES); ?>, <?= htmlspecialchars(json_encode('../../' . $cellData['foto_berat']), ENT_QUOTES); ?>)">
                                                <i class="fas fa-weight-scale"></i>
                                                Lihat
                                            </button>
                                        <?php } else { ?>
                                            <span class="badge badge-ghost">Kosong</span>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if ($cellData['foto_kulit']) { ?>
                                            <button type="button" class="btn btn-ghost btn-sm" onclick="openPhotoModal(<?= htmlspecialchars(json_encode('Foto Kulit Sebelum Oles'), ENT_QUOTES); ?>, <?= htmlspecialchars(json_encode('../../' . $cellData['foto_kulit']), ENT_QUOTES); ?>)">
                                                <i class="fas fa-image"></i>
                                                Lihat
                                            </button>
                                        <?php } else { ?>
                                            <span class="badge badge-ghost">Kosong</span>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php
                                            $editMonitoringPayload = [
                                                'id' => $cellData['id'],
                                                'id_tikus' => $cellData['id_tikus'],
                                                'hari_ke' => $cellData['hari_ke'],
                                                'tanggal' => $cellData['tanggal'],
                                                'berat_badan' => $cellData['berat_badan'],
                                                'skor_eritema' => $skorEritema,
                                                'skor_edema' => $skorEdema,
                                                'foto_berat' => $cellData['foto_berat'],
                                                'foto_kulit' => $cellData['foto_kulit'],
                                            ];
                                        ?>
                                        <div class="flex flex-wrap justify-center gap-2">
                                            <button type="button" class="btn btn-warning btn-sm" onclick="openEditMonitoringModal(<?= htmlspecialchars(json_encode($editMonitoringPayload), ENT_QUOTES); ?>)">
                                                <i class="fas fa-pen"></i>
                                                Edit
                                            </button>
                                            <form action="../../app/controllers/Monitoring.php" method="post" onsubmit="return confirm('Hapus data monitoring hari <?= $hari; ?> beserta fotonya?')">
                                                <input type="hidden" name="id" value="<?= htmlspecialchars($cellData['id']); ?>">
                                                <input type="hidden" name="id_tikus" value="<?= htmlspecialchars($selectedTikusId); ?>">
                                                <button type="submit" name="deleteMonitoring" class="btn btn-error btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                <?php } else { ?>
                                    <td colspan="8">
                                        <span class="badge badge-ghost">Belum ada data</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-outline btn-sm" onclick="openMonitoringModal('<?= htmlspecialchars($selectedTikusId); ?>', '<?= $hari; ?>', '<?= $today; ?>')">
                                            <i class="fas fa-plus"></i>
                                            Input
                                        </button>
                                    </td>
                                <?php } ?>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <dialog id="create_monitoring_modal" class="modal">
            <div class="modal-box">
                <h3 class="text-lg font-bold mb-4">Input Data Monitoring</h3>
                <form action="../../app/controllers/Monitoring.php" method="post" enctype="multipart/form-data" class="space-y-4">
                    <div class="flex flex-col gap-2">
                        <label class="label" for="id_tikus">Tikus</label>
                        <select name="id_tikus" id="id_tikus" class="select select-bordered w-full" required>
                            <option value="">Pilih tikus</option>
                            <?php foreach ($dataTikus as $rowTikus) { ?>
                                <option value="<?= htmlspecialchars($rowTikus['id_tikus']); ?>">
                                    <?= htmlspecialchars($rowTikus['kode_tikus']); ?> - <?= htmlspecialchars($rowTikus['jenis_kelamin']); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-2">
                            <label class="label" for="hari_ke">Hari Ke</label>
                            <select name="hari_ke" id="hari_ke" class="select select-bordered w-full" required>
                                <option value="">Pilih hari</option>
                                <?php for ($hari = 1; $hari <= 14; $hari++) { ?>
                                    <option value="<?= $hari; ?>">Hari <?= $hari; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label class="label" for="tanggal">Tanggal Oles</label>
                            <input type="date" name="tanggal" id="tanggal" class="input input-bordered w-full" required>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="label" for="berat_badan">Berat Badan</label>
                        <label class="input input-bordered flex items-center gap-2">
                            <input type="number" step="0.01" name="berat_badan" id="berat_badan" class="grow" placeholder="Masukkan berat badan" required>
                            <span class="text-sm opacity-60">gram</span>
                        </label>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-2">
                            <label class="label" for="skor_eritema">Skor Eritema</label>
                            <select name="skor_eritema" id="skor_eritema" class="select select-bordered w-full" required>
                                <option value="">Pilih skor eritema</option>
                                <?php foreach ($eritemaOptions as $score => $label) { ?>
                                    <option value="<?= $score; ?>"><?= htmlspecialchars($label); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label class="label" for="skor_edema">Skor Edema</label>
                            <select name="skor_edema" id="skor_edema" class="select select-bordered w-full" required>
                                <option value="">Pilih skor edema</option>
                                <?php foreach ($edemaOptions as $score => $label) { ?>
                                    <option value="<?= $score; ?>"><?= htmlspecialchars($label); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="label" for="foto_berat">Foto Berat Badan</label>
                        <input type="file" name="foto_berat" id="foto_berat" accept="image/*" class="file-input file-input-bordered w-full">
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="label" for="foto_kulit">Foto Kulit Sebelum Oles</label>
                        <input type="file" name="foto_kulit" id="foto_kulit" accept="image/*" class="file-input file-input-bordered w-full">
                    </div>
                    <div class="modal-action">
                        <button type="button" class="btn" onclick="create_monitoring_modal.close()">Batal</button>
                        <button type="submit" name="createMonitoring" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </dialog>

        <dialog id="edit_monitoring_modal" class="modal">
            <div class="modal-box">
                <h3 class="text-lg font-bold mb-4">Edit Data Monitoring</h3>
                <form action="../../app/controllers/Monitoring.php" method="post" enctype="multipart/form-data" class="space-y-4">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="flex flex-col gap-2">
                        <label class="label" for="edit_id_tikus">Tikus</label>
                        <select name="id_tikus" id="edit_id_tikus" class="select select-bordered w-full" required>
                            <option value="">Pilih tikus</option>
                            <?php foreach ($dataTikus as $rowTikus) { ?>
                                <option value="<?= htmlspecialchars($rowTikus['id_tikus']); ?>">
                                    <?= htmlspecialchars($rowTikus['kode_tikus']); ?> - <?= htmlspecialchars($rowTikus['jenis_kelamin']); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-2">
                            <label class="label" for="edit_hari_ke">Hari Ke</label>
                            <select name="hari_ke" id="edit_hari_ke" class="select select-bordered w-full" required>
                                <option value="">Pilih hari</option>
                                <?php for ($hari = 1; $hari <= 14; $hari++) { ?>
                                    <option value="<?= $hari; ?>">Hari <?= $hari; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label class="label" for="edit_tanggal">Tanggal Oles</label>
                            <input type="date" name="tanggal" id="edit_tanggal" class="input input-bordered w-full" required>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="label" for="edit_berat_badan">Berat Badan</label>
                        <label class="input input-bordered flex items-center gap-2">
                            <input type="number" step="0.01" name="berat_badan" id="edit_berat_badan" class="grow" placeholder="Masukkan berat badan" required>
                            <span class="text-sm opacity-60">gram</span>
                        </label>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-2">
                            <label class="label" for="edit_skor_eritema">Skor Eritema</label>
                            <select name="skor_eritema" id="edit_skor_eritema" class="select select-bordered w-full" required>
                                <option value="">Pilih skor eritema</option>
                                <?php foreach ($eritemaOptions as $score => $label) { ?>
                                    <option value="<?= $score; ?>"><?= htmlspecialchars($label); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label class="label" for="edit_skor_edema">Skor Edema</label>
                            <select name="skor_edema" id="edit_skor_edema" class="select select-bordered w-full" required>
                                <option value="">Pilih skor edema</option>
                                <?php foreach ($edemaOptions as $score => $label) { ?>
                                    <option value="<?= $score; ?>"><?= htmlspecialchars($label); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="label" for="edit_foto_berat">Ganti Foto Berat Badan</label>
                        <input type="file" name="foto_berat" id="edit_foto_berat" accept="image/*" class="file-input file-input-bordered w-full">
                        <label class="label cursor-pointer justify-start gap-3">
                            <input type="checkbox" name="delete_foto_berat" id="edit_delete_foto_berat" class="checkbox checkbox-sm">
                            <span class="label-text">Hapus foto berat badan saat ini</span>
                        </label>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="label" for="edit_foto_kulit">Ganti Foto Kulit Sebelum Oles</label>
                        <input type="file" name="foto_kulit" id="edit_foto_kulit" accept="image/*" class="file-input file-input-bordered w-full">
                        <label class="label cursor-pointer justify-start gap-3">
                            <input type="checkbox" name="delete_foto_kulit" id="edit_delete_foto_kulit" class="checkbox checkbox-sm">
                            <span class="label-text">Hapus foto kulit saat ini</span>
                        </label>
                    </div>
                    <div class="modal-action">
                        <button type="button" class="btn" onclick="edit_monitoring_modal.close()">Batal</button>
                        <button type="submit" name="updateMonitoring" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </dialog>

        <dialog id="photo_preview_modal" class="modal">
            <div class="modal-box max-w-3xl">
                <div class="flex items-center justify-between gap-4 mb-4">
                    <h3 id="photo_preview_title" class="text-lg font-bold">Preview Foto</h3>
                    <button type="button" class="btn btn-sm btn-circle btn-ghost" onclick="closePhotoModal()" aria-label="Tutup">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="rounded-lg bg-base-200 p-2">
                    <img id="photo_preview_image" src="" alt="Preview foto monitoring" class="max-h-[70vh] w-full rounded-md object-contain">
                </div>
                <div class="modal-action">
                    <form method="dialog">
                        <button class="btn">Tutup</button>
                    </form>
                </div>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button>Tutup</button>
            </form>
        </dialog>
    </main>

    <script>
        function changeSelectedTikus(idTikus) {
            window.location.href = 'monitoring.php?id_tikus=' + encodeURIComponent(idTikus);
        }

        function openMonitoringModal(idTikus, hariKe, tanggal) {
            document.getElementById('id_tikus').value = idTikus;
            document.getElementById('hari_ke').value = hariKe;
            document.getElementById('tanggal').value = tanggal;
            document.getElementById('berat_badan').value = '';
            document.getElementById('skor_eritema').value = '';
            document.getElementById('skor_edema').value = '';
            document.getElementById('foto_berat').value = '';
            document.getElementById('foto_kulit').value = '';
            create_monitoring_modal.showModal();
        }

        function openEditMonitoringModal(data) {
            document.getElementById('edit_id').value = data.id;
            document.getElementById('edit_id_tikus').value = data.id_tikus;
            document.getElementById('edit_hari_ke').value = data.hari_ke;
            document.getElementById('edit_tanggal').value = data.tanggal;
            document.getElementById('edit_berat_badan').value = data.berat_badan;
            document.getElementById('edit_skor_eritema').value = data.skor_eritema;
            document.getElementById('edit_skor_edema').value = data.skor_edema;
            document.getElementById('edit_foto_berat').value = '';
            document.getElementById('edit_foto_kulit').value = '';
            document.getElementById('edit_delete_foto_berat').checked = false;
            document.getElementById('edit_delete_foto_kulit').checked = false;
            document.getElementById('edit_delete_foto_berat').disabled = !data.foto_berat;
            document.getElementById('edit_delete_foto_kulit').disabled = !data.foto_kulit;
            edit_monitoring_modal.showModal();
        }

        function openPhotoModal(title, imageUrl) {
            document.getElementById('photo_preview_title').textContent = title;
            document.getElementById('photo_preview_image').src = imageUrl;
            document.getElementById('photo_preview_modal').showModal();
        }

        function closePhotoModal() {
            document.getElementById('photo_preview_modal').close();
            document.getElementById('photo_preview_image').src = '';
        }
    </script>

<?php

include_once (__DIR__ . "/../layouts/footer.php");

?>
