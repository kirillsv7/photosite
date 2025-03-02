import { MediaFile } from "@/types/models/MediaFile";
import { Slug } from "@/types/models/Slug";

export type Category = {
  id: string
  title: string
  description: string | null
  image: MediaFile
  slug: Slug
  created_at: Date
  updated_at?: Date
}
