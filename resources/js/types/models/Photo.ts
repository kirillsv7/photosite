import { MediaFile } from "@/types/models/MediaFile";
import { Slug } from "@/types/models/Slug";

export type Photo = {
  id: string
  title: string
  image: MediaFile
  slug: Slug
  created_at: Date
  updated_at?: Date
}
