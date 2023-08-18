import type { Timeline, UserPermissions, UserRole } from '@/types'
import { usePage } from '@inertiajs/vue3'

interface DataActivityStatus {
  status_aktivitas: Timeline['status_aktivitas']
}

type DataStatusCode = 400 | 100 | '400' | '100'

const page = () => {
  return usePage()
}

const userPermissions = () => {
  return page().props.auth.permissions
}

const userRole = (): UserRole => {
  return page().props.auth.role
}

const isAdmin = () => {
  const role = userRole()
  if (role === 'admin') return true
  return false
}

function can (permissions: UserPermissions) {
  return userPermissions().includes(permissions)
}

function isModuleEditable (code: DataStatusCode) {
  if (code === '100' || code === 100) return true
  return false
}

function isEditable (data: DataActivityStatus) {
  const status = data.status_aktivitas
  if (status === 'Dibuat' || status === 'Ditolak' || status === 'Diterima Bertahap') return true
  return false
}

function isApprovable (data: DataActivityStatus) {
  const status = data.status_aktivitas
  if (status === 'Diajukan') return true
  return false
}

function isSubmitted (data: DataActivityStatus) {
  const status = data.status_aktivitas
  if (status === 'Diajukan' || status === 'Dibayar') return true
  return false
}

function isRejected (data: DataActivityStatus) {
  const status = data.status_aktivitas
  if (status === 'Ditolak') return true
  return false
}

function isApproved (data: DataActivityStatus) {
  const status = data.status_aktivitas
  if (status === 'Disetujui') return true
  return false
}

export {
  can,
  isModuleEditable,
  isEditable,
  isApprovable,
  isSubmitted,
  isRejected,
  isApproved,
  isAdmin,
  userRole,
  userPermissions
}
