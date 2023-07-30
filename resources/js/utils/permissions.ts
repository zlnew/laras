import { usePage } from "@inertiajs/vue3";

type PermissionsModules =
  'master users'|
  'master rekening'|
  'master satuan'|
  'master roles & permissions'|
  'view proyek'|
  'create & modify proyek'|
  'view rab'|
  'create & modify rab'|
  'approve rab'|
  'view rap'|
  'create & modify rap'|
  'approve rap'|
  'view pengajuan dana'|
  'create & modify pengajuan dana'|
  'approve pengajuan dana'|
  'view pencairan dana'|
  'create & modify pencairan dana'|
  'approve pencairan dana'|
  'receipt pencairan dana'|
  'view penagihan'|
  'create & modify penagihan'|
  'receipt penagihan'|
  'view laporan'|
  'generate laporan';

const userPermissions = () => {
  const page = usePage();
  return page.props.permissions;
}

export type ActivityStatus = 'Dibuat' | 'Diajukan' | 'Diperiksa' | 'Dievaluasi' | 'Disetujui' | 'Ditolak';

function can(permissions: PermissionsModules) {
  return userPermissions().includes(permissions);
}

function isEditable(status: ActivityStatus) {
  if (status === 'Dibuat' || status === 'Ditolak') return true;
  return false;
}

function isApprovable(status: ActivityStatus) {
  if (status === 'Diajukan' || status === 'Dievaluasi' || status === 'Diperiksa') return true;
  return false;
}

function isSubmitted(status: ActivityStatus) {
  if (status === 'Diajukan') return true;
  return false;
}

function isRejected(status: ActivityStatus) {
  if (status === 'Ditolak') return true;
  return false;
}

function isApproved(status: ActivityStatus) {
  if (status === 'Disetujui') return true;
  return false;
}

export {
  can,
  isEditable,
  isApprovable,
  isSubmitted,
  isRejected,
  isApproved
};

