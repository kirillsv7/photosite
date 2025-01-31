import { StorageInfo } from "@/types/models/StorageInfo";

export type MediaFile = {
  id: string
  original_filename: string
  filename: string
  storage_info: StorageInfo
  sizes: Record<string, string>
  links: Record<string, string>
  extension: string
  mimetype: string
  info: Record<string, any>
  mediable_type: string
  mediable_id: string
  created_at: Date
  updated_at?: Date
}
