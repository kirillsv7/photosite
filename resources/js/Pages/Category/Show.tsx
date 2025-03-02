import { usePage } from "@inertiajs/react";
import { PageProps } from "@/types";
import { Category } from "@/types/models/Category";
import AppLayout from "@/Layouts/AppLayout";

export default function CategoryShowPage() {
  const {props: {category}} = usePage<PageProps<{category: Category}>>()

  const links = Object.entries(category.image.links)

  return (
    <AppLayout title={category.title}>


      {category.title && <p>{category.title}</p>}

      {category.description && <p>{category.description}</p>}

      <picture>
        {links.map(([size, path]) => (
          <source
            key={size}
            media={`(max-width: ${size}px)`}
            srcSet={path}
          />
        ))}

        <img
          alt={category.title}
          src={links[Object.keys(category.image.links).length - 1][1]}
        />
      </picture>
    </AppLayout>
  )
}
