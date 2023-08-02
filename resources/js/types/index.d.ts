export interface Pagination {
    total: number;
    per_page: number;
    current_page: number;
    last_page: number;
    first_page_url: string;
    last_page_url: string;
    next_page_url: string | null;
    prev_page_url: string | null;
    path: string;
    from: number;
    to: number;
    links: Array<PaginationLink>;
}

export interface PaginationLink {
    active: boolean;
    label: string;
    url: string;
}

export interface DataWithPagination<T> extends Pagination {
    data: Array<T>;
}

export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
}

export interface Role {
    id: number;
    name: string;
}

export interface Flash {
    success: string;
    error: string;
}

export interface File {
    id_file: number;
    file_name: string;
    file_path: string;
    model_id: string;
}

export interface Proyek {
    id_proyek: string;
    nama_proyek: string;
    nomor_kontrak: string;
    tanggal_kontrak: string;
    pengguna_jasa: string;
    penyedia_jasa: string;
    tahun_anggaran: string;
    nomor_spmk: string;
    tanggal_spmk: string;
    nilai_kontrak: string;
    tanggal_mulai: string;
    durasi: number;
    tanggal_selesai: string;
    id_user: number;
    id_rekening: string;
    status_proyek: '100' | '400';
};

export interface RAB {
    id_rab: string;
    id_proyek: Proyek['id_proyek'];
    tax: string;
    additional_tax: string;
    status_rab: '100' | '400';
    status_aktivitas: 'Dibuat' | 'Diajukan' | 'Ditolak' | 'Disetujui';
}

export interface DetailRAB {
    id_detail_rab: number;
    id_rab: RAB['id_rab'];
    id_satuan: Satuan['id_satuan'];
    uraian: string;
    volume: string;
    harga_satuan: string;
    keterangan: string;
};

export interface RAP {
    id_rap: string;
    id_proyek: Proyek['id_proyek'];
    status_rap: '100' | '400';
    status_aktivitas: 'Dibuat' | 'Diajukan' | 'Dievaluasi' | 'Ditolak' | 'Disetujui';
}

export interface DetailRAP {
    id_detail_rap: number;
    id_rap: RAP['id_rap'];
    id_satuan: Satuan['id_satuan'];
    uraian: string;
    volume: string;
    harga_satuan: string;
    keterangan: string;
    status_uraian: 'Gaji' | 'Sewa' | 'Beli' | 'Subkon/Vendor';
};

export interface PengajuanDana {
    id_pengajuan_dana: string;
    keperluan: string;
    tanggal_pengajuan: string;
    status_pengajuan: '100' | '400';
    status_aktivitas: 'Dibuat' | 'Diajukan' | 'Dievaluasi' | 'Ditolak' | 'Disetujui';
    id_proyek: Proyek['id_proyek'];
};

export interface DetailPengajuanDana {
    id_detail_pengajuan_dana: number;
    id_pengajuan_dana: PengajuanDana['id_pengajuan_dana'];
    id_detail_rap: DetailRAP['id_detail_rap'];
    id_rekening: Rekening['id_rekening'];
    uraian: string;
    jumlah_pengajuan: string;
    jenis_pembayaran: string;
};

export interface PencairanDana {
    id_pencairan_dana: string;
    keperluan: string;
    status_pencairan: '100' | '400';
    status_aktivitas: 'Dibuat' | 'Dibayar' | 'Ditolak' | 'Diterima Bertahap' | 'Diterima';
    id_proyek: Proyek['id_proyek'];
};

export interface DetailPencairanDana {
    id_detail_pencairan_dana: number;
    id_pencairan_dana: PencairanDana['id_pencairan_dana'];
    id_detail_pengajuan_dana: DetailPengajuanDana['id_detail_pengajuan_dana'];
    jumlah_pencairan: string;
    status_pembayaran: '100' | '400';
};

export interface Penagihan {
    id_penagihan: string;
    id_proyek: Proyek['id_proyek'];
    id_rekening: Rekening['id_rekening'];
    keperluan: string;
    tanggal_pengajuan: string;
    nomor_sp2d: string;
    tanggal_sp2d: string;
    tanggal_terbit: string;
    tanggal_cair: string;
    potongan_ppn:string;
    potongan_pph: string;
    potongan_lainnya: string;
    keterangan_potongan_lainnya: string;
    kas_masuk: 'Utang' | 'Setoran Modal';
    status_penagihan: '100' | '400';
    status_aktivitas: 'Dibuat' | 'Diajukan' | 'Ditolak' | 'Diterima Bertahap' | 'Diterima';
}

export interface DetailPenagihan {
    id_detail_penagihan: number;
    id_penagihan: Penagihan['id_penagihan'];
    id_detail_rab: DetailRAB['id_detail_rab'];
    volume_penagihan: string;
    harga_satuan_penagihan: string;
    status_diterima: '100' | '400';
};

export interface Timeline {
    id_timeline: number;
    user_id: User['id'];
    model_id: string | number;
    model_type: string;
    catatan: string;
    status_aktivitas: 'Dibuat' | 'Diajukan' | 'Dibayar' | 'Dievaluasi' | 'Ditolak' | 'Disetujui' | 'Diterima Bertahap' | 'Diterima';
};

export interface Satuan {
    id_satuan: number;
    nama_satuan: string;
};

export interface Rekening {
    id_rekening: string;
    nama: string;
    jabatan: string;
    nama_bank: string;
    nomor_rekening: string;
    nama_rekening: string;
    tujuan_rekening: string;
};

export type UserRole = 'admin' | 'manajer proyek' | 'kepala divisi' | 'direktur utama' | 'keuangan';

export type UserPermissions =
  'view proyek'|
  'create & modify proyek'|

  'view rab'|
  'create & modify rab'|
  'approve rab'|

  'view rap'|
  'create & modify rap'|
  'evaluate rap'|
  'approve rap'|

  'view pengajuan dana'|
  'create & modify pengajuan dana'|
  'evaluate pengajuan dana'|
  'approve pengajuan dana'|

  'view pencairan dana'|
  'create & modify pencairan dana'|
  'receipt pencairan dana'|

  'view penagihan'|
  'create & modify penagihan'|
  'receipt penagihan';

interface Auth {
    user: User;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: Auth;
    flash: Flash;
    query: Object;
    role: UserRole; 
    permissions: UserPermissions;
};