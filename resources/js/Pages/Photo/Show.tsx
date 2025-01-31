import { usePage } from "@inertiajs/react";
import { PageProps } from "@/types";
import { Photo } from "@/types/models/Photo";
import AppLayout from "@/Layouts/AppLayout";

export default function PhotoShowPage() {
  const {props: {photo}} = usePage<PageProps<{photo: Photo}>>()

  const links = Object.entries(photo.image.links)

  return (
    <AppLayout title={photo.title}>
      <picture>
        {links.map(([size, path]) => (
          <source
            key={size}
            media={`(max-width: ${size}px)`}
            srcSet={path}
          />
        ))}

          <img
            alt={photo.title}
            src={links[Object.keys(photo.image.links).length - 1][1]}
          />
      </picture>
    </AppLayout>
  )
}
