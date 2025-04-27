import React from "react";

const Team = () => {
  const members = [
    { name: "Dr. Farid Allaki", role: "Chirurgien-Dentiste", bio: "Spécialisé en implantologie et soins esthétiques." },
    { name: "Dr. Meryem El Atouani", role: "Orthodontiste", bio: "Experte dans le suivi des enfants et adolescents." },
    { name: "Dr. Naji Hassain", role: "Endodontiste", bio: "Soins approfondis des racines dentaires." },
  ];

  return (
    <div className="max-w-4xl mx-auto p-6">
      <h1 className="text-3xl font-bold text-center text-primary mb-6">Notre Équipe</h1>
      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
        {members.map((m, i) => (
          <div key={i} className="border p-4 rounded-lg shadow bg-white">
            <h2 className="text-xl font-semibold text-gray-800">{m.name}</h2>
            <p className="text-sm text-gray-500 mb-1">{m.role}</p>
            <p className="text-gray-600 text-sm">{m.bio}</p>
          </div>
        ))}
      </div>
    </div>
  );
};

export default Team;