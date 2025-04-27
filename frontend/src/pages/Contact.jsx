import React from "react";

const Contact = () => {
  return (
    <div className="max-w-3xl mx-auto p-6">
      <h1 className="text-3xl font-bold text-center text-primary mb-6">Nous Contacter</h1>
      <div className="bg-white p-6 rounded-lg shadow">
        <p className="mb-4 text-gray-700">
          Vous pouvez nous joindre directement via les coordonnées ci-dessous :
        </p>
        <ul className="mb-6 text-gray-600 space-y-1">
          <li><strong>📍 Adresse :</strong> 123 Rue des Dents, Casablanca, Maroc</li>
          <li><strong>📞 Téléphone :</strong> +212 6 00 00 00 00</li>
          <li>
            <strong>📧 Email :</strong>{" "}
            <a href="mailto:contact@dentalis.ma" className="text-blue-600 underline">
              contact@dentalis.ma
            </a>
          </li>
          <li><strong>🕑 Horaires :</strong> Lundi à Samedi, 9h à 18h</li>
        </ul>
        <p className="text-sm text-gray-500">
          Cliquez sur l'adresse email pour ouvrir votre messagerie préférée.
        </p>
      </div>
    </div>
  );
};

export default Contact;
