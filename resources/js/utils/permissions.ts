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

function can(permissions: PermissionsModules) {
  return userPermissions().includes(permissions);
}

export {
  can
};

