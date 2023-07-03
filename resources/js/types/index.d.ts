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
    rab: RAB;
    rap: RAP;
};

export interface RAB {
    id_rab: string;
    id_proyek: string;
    tax: number;
    additional_tax: number;
    status_rab: 100 | 400;
    created_at: Date;
    updated_at: Date;
    proyek: Proyek;
    detail: Array<DetailRAB>;
}

export interface DetailRAB {
    id_detail_rab: number;
    id_rab: string;
    id_satuan: string;
    uraian: string;
    volume: number;
    harga_satuan: number;
    keterangan: string;
    created_at: Date;
    updated_at: Date;
    deleted_at: Date;
    rab: RAB;
    satuan: Satuan;
};

export interface RAP {
    id_rap: string;
    id_proyek: string;
    status_rap: 100 | 400;
    created_at: Date;
    updated_at: Date;
    proyek: Proyek;
    detail: Array<DetailRAP>;
}

export interface DetailRAP {
    id_detail_rap: number;
    id_rap: string;
    id_satuan: string;
    uraian: string;
    volume: number;
    harga_satuan: number;
    keterangan: string;
    status_uraian: string;
    created_at: Date;
    updated_at: Date;
    deleted_at: Date;
    rap: RAP;
    satuan: Satuan;
};

export interface PengajuanDana {
    id_pengajuan_dana: string;
    id_rap: string;
    keterangan: string;
    status_pengajuan: 100 | 400;
    created_at: Date;
    updated_at: Date;
    deleted_at: Date;
    rap: RAP;
    detail: Array<DetailPengajuanDana>;
};

export interface DetailPengajuanDana {
    id_detail_pengajuan_dana: number;
    id_pengajuan_dana: string;
    id_detail_rap: number;
    uraian: string;
    jumlah_pengajuan: number;
    jenis_pembayaran: string;
    nama_rekening: string;
    nomor_rekening: string;
    nama_bank: string;
    created_at: Date;
    updated_at: Date;
    deleted_at: Date;
    pengajuan_dana: PengajuanDana;
    detail_rap: DetailRAP;
};

export interface PencairanDana {
    id_pencairan_dana: string;
    id_pengajuan_dana: string;
    keterangan: string;
    status_pencairan: 100 | 400;
    created_at: Date;
    updated_at: Date;
    deleted_at: Date;
    pengajuan_dana: PengajuanDana;
    detail: Array<DetailPencairanDana>;
};

export interface DetailPencairanDana {
    id_detail_pencairan_dana: number;
    id_pencairan_dana: string;
    id_detail_pengajuan_dana: number;
    jumlah_pencairan: number;
    created_at: Date;
    updated_at: Date;
    deleted_at: Date;
    pencairan_dana: PencairanDana;
    detail_pengajuan_dana: DetailPengajuanDana;
};

export interface Persetujuan {
    id_persetujuan: number;
    user_id: number;
    model_id: string;
    model_type: string;
    catatan:string;
    created_at: Date;
    updated_at: Date;
    deleted_at: Date;
};

export interface Satuan {
    id_satuan: number;
    nama_satuan: string;
};

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
    permissions: string[];
    flash: Flash;
};
