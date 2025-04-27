import React from "react";

const Services = () => {
  const services = [
    { title: "Consultation", description: "Diagnostic complet et recommandations personnalisées." },
    { title: "Détartrage", description: "Nettoyage professionnel des dents pour une hygiène optimale." },
    { title: "Blanchiment", description: "Traitement esthétique pour des dents plus blanches." },
    { title: "Soins enfants", description: "Traitements adaptés aux plus jeunes." },
  ];

  return (
    <div className="max-w-5xl mx-auto p-6">
      <h1 className="text-3xl font-bold text-center text-primary mb-6">Nos Services</h1>
      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
        {services.map((s, i) => (
          <div key={i} className="border p-4 rounded-lg shadow bg-white">
            <h2 className="text-xl font-semibold text-gray-800 mb-2">{s.title}</h2>
            <p className="text-gray-600">{s.description}</p>
          </div>
        ))}
      </div>
    </div>
  );
};

export default Services;