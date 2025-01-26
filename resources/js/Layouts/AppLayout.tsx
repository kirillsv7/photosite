import { ReactNode } from "react";
import { Head } from "@inertiajs/react";

type Props = {
  title: string;
  children: ReactNode;
}

export default function AppLayout({title, children}: Props) {
  return <>
    <Head title={title}/>

    {children}
  </>
}
