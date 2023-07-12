export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
}

export interface Flash {
    success: string;
    error: string;
}

export interface Proyek {
    id_proyek: string;
    nama_proyek: string;
    tahun_anggaran: string;
    pengguna_jasa: string;
    waktu_mulai: Date;
    waktu_selesai: Date;
    nilai_kontrak: number;
    pic: string;
    status_proyek: 100 | 400;
    created_at: Date;
    updated_at: Date;
    deleted_at: Date;
    [key: string]: any;
};

export interface RAB {
    id_rab: string;
    id_proyek: Proyek['id_proyek'];
    tax: number;
    additional_tax: number;
    status_rab: 100 | 400;
    status_aktivitas: 'Dibuat' | 'Diajukan' | 'Disetujui';
    created_at: Date;
    updated_at: Date;
    deleted_at: Date;
    [key: string]: any;
}

export interface DetailRAB {
    id_detail_rab: number;
    id_rab: RAB['id_rab'];
    id_satuan: Satuan['id_satuan'];
    uraian: string;
    volume: number;
    harga_satuan: number;
    keterangan: string;
    created_at: Date;
    updated_at: Date;
    deleted_at: Date;
    [key: string]: any;
};

export interface RAP {
    id_rap: string;
    id_proyek: Proyek['id_proyek'];
    status_rap: 100 | 400;
    status_aktivitas: 'Dibuat' | 'Diajukan' | 'Diperiksa' | 'Disetujui';
    created_at: Date;
    updated_at: Date;
    deleted_at: Date;
    [key: string]: any;
}

export interface DetailRAP {
    id_detail_rap: number;
    id_rap: RAP['id_rap'];
    id_satuan: Satuan['id_satuan'];
    uraian: string;
    volume: number;
    harga_satuan: number;
    keterangan: string;
    status_uraian: string;
    created_at: Date;
    updated_at: Date;
    deleted_at: Date;
    [key: string]: any;
};

export interface Keuangan {
    id_keuangan: string;
    id_proyek: Proyek['id_proyek'];
    keperluan: string;
    created_at: Date;
    updated_at: Date;
    deleted_at: Date;
    [key: string]: any;
}

export interface PengajuanDana {
    id_pengajuan_dana: string;
    id_keuangan: Keuangan['id_keuangan'];
    status_pengajuan: 100 | 400;
    status_aktivitas: 'Dibuat' | 'Diajukan' | 'Dievaluasi' | 'Disetujui';
    tanggal_pengajuan: Date;
    created_at: Date;
    updated_at: Date;
    deleted_at: Date;
    [key: string]: any;
};

export interface DetailPengajuanDana {
    id_detail_pengajuan_dana: number;
    id_pengajuan_dana: PengajuanDana['id_pengajuan_dana'];
    id_detail_rap: DetailRAP['id_detail_rap'];
    id_rekening: Rekening['id_rekening'];
    uraian: string;
    jumlah_pengajuan: number;
    jenis_pembayaran: string;
    created_at: Date;
    updated_at: Date;
    deleted_at: Date;
    [key: string]: any;
};

export interface PencairanDana {
    id_pencairan_dana: string;
    id_keuangan: Keuangan['id_keuangan'];
    status_pencairan: 100 | 400;
    status_aktivitas: 'Dibuat' | 'Dibayar' | 'Dilunasi' | 'Diterima';
    created_at: Date;
    updated_at: Date;
    deleted_at: Date;
    [key: string]: any;
};

export interface DetailPencairanDana {
    id_detail_pencairan_dana: number;
    id_pencairan_dana: PencairanDana['id_pencairan_dana'];
    id_detail_pengajuan_dana: DetailPengajuanDana['id_detail_pengajuan_dana'];
    jumlah_pencairan: number;
    created_at: Date;
    updated_at: Date;
    deleted_at: Date;
    [key: string]: any;
};

export interface Timeline {
    id_timeline: number;
    user_id: User['id'];
    model_id: RAB['id_rab'] | RAP['id_rap'] | PengajuanDana['id_pengajuan_dana'] | PencairanDana['id_pencairan_dana'];
    model_type: string;
    catatan: string;
    status_aktivitas: string;
    created_at: Date;
    updated_at: Date;
    deleted_at: Date;
    [key: string]: any;
};

export interface Satuan {
    id_satuan: number;
    nama_satuan: string;
    created_at: Date;
    updated_at: Date;
    deleted_at: Date;
    [key: string]: any;
};

export interface Rekening {
    id_rekening: string;
    nama: string;
    jabatan: string;
    nama_bank: string;
    nomor_rekening: string;
    nama_rekening: string;
    created_at: Date;
    updated_at: Date;
    deleted_at: Date;
    [key: string]: any;
};

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: { user: User };
    role: 'admin' | 'manajer proyek' | 'kepala divisi' | 'direktur utama' | 'keuangan'; 
    permissions: string[];
    query: Object;
    flash: Flash;
};
